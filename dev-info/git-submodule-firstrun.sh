#!/bin/sh

echo "Add submodule from .gitmodule after cloning a repo."
echo ""
echo "You have to run this script at the root directory of your git repository."

# see <https://stackoverflow.com/questions/11258737/restore-git-submodules-from-gitmodules>

set -e

git config -f .gitmodules --get-regexp '^submodule\..*\.path$' |
    while read path_key path
    do
        url_key=$(echo $path_key | sed 's/\.path/.url/')
        url=$(git config -f .gitmodules --get "$url_key")
        git submodule add $url $path
    done