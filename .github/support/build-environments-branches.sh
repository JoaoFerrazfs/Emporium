#!/bin/bash
environmentBranch=$1

echo "Setting up Git user identity..."
git config --local user.name "$GIT_COMMITTER_NAME"
git config --local user.email "$GIT_COMMITTER_EMAIL"

echo "Deleting $environmentBranch..."
git branch -D $environmentBranch &> /dev/null

echo "Recreating $environmentBranch..."
git checkout -b $environmentBranch

if [ -n "$shoulRemove" ]; then
    allBranches="${validatedBranches}"
else
    allBranches="${validatedIssueBranches},${validatedBranches}"
fi

allBranches=$(echo "$allBranches" | sed 's/ *, */,/g; s/,$//')

echo "Prepared branches: $allBranches "

IFS=, read -ra BranchArray <<< "$allBranches"

error_file="error.log"
touch "$error_file"

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
