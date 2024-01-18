#!/bin/bash
environmentBranch=$1

echo "Checkout $environmentBranch..."
git checkout $environmentBranch &> /dev/null

supportDir="./.github/support/"
if [ ! -d "$supportDir" ]; then
  mkdir -p "$supportDir"
fi

branchFile="./.github/support/$environmentBranch-branches.txt"

if [ ! -e "$branchFile" ]; then
  touch "$branchFile"
fi

cat "./.github/support/$environmentBranch-branches.txt"

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
export validatedBranches
