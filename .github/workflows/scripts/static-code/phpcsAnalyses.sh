#!/bin/bash

MODIFIED_FILES=$1

IFS=' ' read -ra FILES <<< $MODIFIED_FILES
for file in "${FILES[@]}"; do
if [ ! -f "$file" ]; then
  echo "File $file was excluded. Skipping PHPCS process."
  continue
fi

echo "Running PHPCS on file: $file"
vendor/bin/phpcs "$file"
echo "Nothing wrong with file: $file"
done
