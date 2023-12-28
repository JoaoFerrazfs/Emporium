#!/bin/bash

MODIFIED_FILES=$1

IFS=' ' read -ra FILES <<< $MODIFIED_FILES
for file in "${FILES[@]}"; do
if [ ! -f "$file" ]; then
  echo "File $file was excluded. Skipping PHPMD process."
  continue
fi

echo "Running PHPMD on file: $file"
vendor/bin/phpmd "$file" text phpmd.xml
echo "Nothing wrong with file: $file"
done
