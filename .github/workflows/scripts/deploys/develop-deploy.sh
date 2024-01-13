#!/bin/bash
NEW_BRANCH=$1
ENVIRONMENT=$2
git fetch --all

# Certifique-se de estar na branch 'develop-deploy'
git checkout develop-deploy

while IFS=, read -r branch; do
    # Remover espaços em branco no início e no final do nome da branch
    branch=$(echo "$branch" | sed 's/^[ \t]*//;s/[ \t]*$//')

    # Verificar se a branch remota existe
    if git ls-remote --exit-code --heads origin "$branch" &> /dev/null; then
        echo "Mergeando branch: $branch"
        git rebase master

#        git checkout teste-branch &> /dev/null
#        git merge $branch --no-ff -m "Merge $branch into develop-deploy"
#        git checkout develop-deploy &> /dev/null
    else
        echo "A branch remota $branch não existe."
    fi
done < branches.csv
