#!/bin/bash
environmentBranch=$1
shouldRemove=$2

echo "Fluxo de remoção $shouldRemove..."
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
      git checkout "$branch" &> /dev/null
      git log --pretty=format:"%h" master | grep "$(git log --pretty=format:"%h" -1 "$branch")" &> /dev/null
      branch_merged=$?

      if [[ "$branch_merged" == "0" ]]; then
        git rebase master
      fi

      validatedBranches+="$branch,"
    fi
done

validatedBranches="${validatedBranches%,}"
echo "validatedBranches=${validatedBranches%,}" >> $GITHUB_ENV


git checkout master
echo "Setting up Git user identity..."
git config --local user.name "$GIT_COMMITTER_NAME"
git config --local user.email "$GIT_COMMITTER_EMAIL"

echo "Deleting $environmentBranch..."
git branch -D $environmentBranch &> /dev/null

echo "Recreating $environmentBranch..."
git checkout -b $environmentBranch

echo  "Branches preexistentes: ${validatedBranches}"
echo  "Issue existentes: ${validatedIssueBranches}"

IFS=',' read -ra branchesArray <<< "${validatedBranches}"
IFS=',' read -ra issueBranchesArray <<< "${validatedIssueBranches}"

if [ -n "$shouldRemove" ]; then
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

echo "Prepared branches: $allBranches"

IFS=, read -ra BranchArray <<< "$allBranches"

error_file="error.log"
touch "$error_file"

if [ "${allBranches}" ]; then

  for branch in "${BranchArray[@]}"; do
      echo "Chekout to $branch."
      git checkout $branch  &> /dev/null

      echo "Rebasing $branch with main..."
      git rebase master 2>> "$error_file"
      error=$?
      if [[ "$error" != "0" ]]; then
          error=$(tail -n 1 "$error_file")
          echo "An error occurred while rebasing '$environmentBranch' into '$branch': $error"
          exit 1
      else
          echo -e "Rebase successful\n"
      fi

      echo "Merge $branch into '$environmentBranch'..."

      git checkout $environmentBranch &> /dev/null
      git merge $branch --no-edit 2>> "$error_file"
      error=$?
      if [[ "$error" != "0" ]]; then
          error=$(tail -n 1 "$error_file")
          echo "An error occurred while merge '$branch' into '$environmentBranch': $error"
          exit 1
      else
          echo -e "Merge successful\n"
      fi
  done

  echo "Creating new branches file to'$environmentBranch'"

else
  echo "The new branch '$environmentBranch Branch' will be empty with only master as base"
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

git push --force origin $environmentBranch 2>> "$error_file"
error=$?
if [[ "$error" != "0" ]]; then
 error=$(tail -n 1 "$error_file")
 echo "An error occurred while merge '$branch' into '$environmentBranch': $error"
 exit 1
else
 echo -e "Merge successful\n"
fi
