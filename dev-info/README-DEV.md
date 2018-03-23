
# Developer Info

## Get started
- Clone the source from github <https://github.com/oger000/ogerarch> or fork at github.
- Initiating the submodules the first time after a clone is a mess in git, but the script `dev-info/git-submodule-firstrun.sh` should do the job for you.
- Happy coding.

## Some hints
- If adding or massive changing templates for printing use the _tiny but strong_ library instead of the homegrown and deprecated php templating syntax. An example is the usage of `web/pdftemplates/report/StratumListBda.odt` in `web/php/scripts/report.php`.
- If there exits the same file with and without the ending 12 (e.g. `ArchFind.class.php`and `ArchFind12.class.php` then develop on the file ending with 12. The 12 indicates a rewrite in 2012. The other file is only for safety's sake if the rewrite is not complete in some parts. The same rule applies to directory naming.
- The usage of tabs and space changed over time. The latest convention is using spaces; two spaces per indentation.
