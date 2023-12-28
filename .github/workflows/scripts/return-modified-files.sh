#!/bin/bash

PR_NUMBER=$1

BASE_BRANCH=$(gh pr view $PR_NUMBER --json baseRefName | jq -r '.baseRefName')
MODIFIED_FILES=$(git diff --name-only origin/$BASE_BRANCH)
FILES=$(echo $MODIFIED_FILES | tr '\n' ' ')
echo "MODIFIED_FILES=${FILES}" >> $GITHUB_ENV
