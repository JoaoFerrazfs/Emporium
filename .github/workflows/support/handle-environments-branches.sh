#!/bin/bash
environmentBranch=$1

echo "Checkout $environmentBranch..."
git checkout $environmentBranch &> /dev/null

branchFile="./.github/workflows/support/$environmentBranch-branches.txt"

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
echo "validatedBranches= ${validatedBranches%,}" >> $GITHUB_ENV
