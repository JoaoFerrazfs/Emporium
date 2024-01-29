#!/bin/bash
environmentBranch=$1
sentIssueBranches=$2
mustRemove=$3

echo -e "\nStarting branches management"

echo "Checkout $environmentBranch"
git checkout $environmentBranch &> /dev/null

supportDir="./.github/support/"
if [ ! -d "$supportDir" ]; then
  mkdir -p "$supportDir"
fi

branchFile="./.github/support/$environmentBranch-branches.txt"

if [ ! -e "$branchFile" ]; then
  touch "$branchFile"
fi

IFS=, read -ra branches < "$branchFile"
validatedBranches=""

for branch in "${branches[@]}"; do
    branch=$(echo "$branch" | sed 's/^[ \t]*//;s/[ \t]*$//')

    set +e
    git ls-remote --exit-code --heads origin "$branch" &> /dev/null
    branch_exists=$?

    if [[ "$branch_exists" == "0" ]]; then
      git checkout $branch &> /dev/null
      git log --pretty=format:"%h" master | grep `git log --pretty=format:"%h" -1 $branch` &> /dev/null
      branch_merged=$?

      if [[ "$branch_merged" == "0" ]]; then
        echo "error= 🚫 The **$branch** exists, but has already been merged." >> $GITHUB_ENV
        continue
      fi

    else
      echo "error= 🚫 The **$branch** non exists." >> $GITHUB_ENV
      continue
    fi

     validatedBranches+="$branch,"
done

validatedBranches="${validatedBranches%,}"
echo "validatedBranches=${validatedBranches%,}" >> $GITHUB_ENV

echo -e "Branches management finished\n"

echo -e "Starting branches update"

git checkout master

echo -e "Configuring gitHub to assign changes \n"
git config --local user.name "GitHub Actions"
git config --local user.email "actions@github.com"

echo "Deleting $environmentBranch..."
git branch -D $environmentBranch &> /dev/null

echo "Recreating $environmentBranch..."
git checkout -b $environmentBranch

echo  "Branches pre-existing in the environment: ${validatedBranches}"
echo  "Branches sent to be worked: ${sentIssueBranches}"

IFS=',' read -ra branchesArray <<< "${validatedBranches}"
IFS=',' read -ra issueBranchesArray <<< "${sentIssueBranches}"

if [ -n "$mustRemove" ]; then
    allBranches=()
    for branch in "${branchesArray[@]}"; do
        if [[ ! " ${issueBranchesArray[@]} " =~ " ${branch} " ]]; then
            allBranches+=("${branch}")
        fi
    done
else
    allBranches=("${issueBranchesArray[@]}" "${branchesArray[@]}")
fi

allBranches=$(IFS=','; echo "${allBranches[*]}")
allBranches=$(echo "$allBranches" | awk -v RS=, -v ORS=, '!a[$1]++ {print $1}')

echo "Branched already unified and ready to be merged: $allBranches"
echo -e "\n"

IFS=, read -ra BranchArray <<< "$allBranches"

error_file="error.log"
touch "$error_file"

echo "Starting merge process"

if [ -n "$allBranches" ] && [ "$allBranches" != "," ]; then

  for branch in "${BranchArray[@]}"; do
      echo "Chekout to $branch."
      git checkout $branch  &> /dev/null

      echo "Rebasing $branch with main..."
      git rebase master
      error=$?
      if [[ "$error" != "0" ]]; then
          echo -e "An error occurred while rebasing '$branch' into '$environmentBranch'" >> "$error_file"
          exit 1
      else
          echo -e "Rebase successful\n"
      fi

      echo "Merge $branch into '$environmentBranch'..."

      git checkout $environmentBranch &> /dev/null
      git merge $branch
      error=$?
      if [[ "$error" != "0" ]]; then
          echo -e "An error occurred while merge '$branch' into '$environmentBranch'" >> "$error_file"
          exit 1
      else
          echo -e "Merge successful\n"
      fi
  done

  echo "Creating new branches file to'$environmentBranch'"

else
  echo "The new branch '$environmentBranch Branch' will be empty with only master as base"
  allBranches=''
fi

supportDir="./.github/support/"
if [ ! -d "$supportDir" ]; then
  mkdir -p "$supportDir"
fi
branchFile="./.github/support/$environmentBranch-branches.txt"
echo "$allBranches" > $branchFile
git add .
git commit -m "add branches file"

echo "Sending updated '$environmentBranch' to github"

git push --force origin $environmentBranch &> /dev/null
error=$?
if [[ "$error" != "0" ]]; then
 echo -e "An error occurred while merge '$branch' into '$environmentBranch'" >> "$error_file"
 exit 1
else
 echo -e "Merge successful\n"
fi
