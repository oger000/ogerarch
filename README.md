# ogerarch
Archaeological Database  
UI Language: DE


## System Requirement
Webserver, PHP, MySql (or MariaDB)   
For windows workstations XAMPP <https://www.apachefriends.org/> has shown good results.

## Install
Copy all files to the location as needed for your web server. For non-development usage only the `web/`directory is needed.  
If you want to use the autobackup feature you have to make the directory `web/autobackup/` writeable for the webserver process.  
Maybe you have to tweak the php.ini. `dev-info/php-ini/php.ini.ogerarch` contains more info on this.

## Config
The config is done in the file `web/config/config.localonly.inc.php`. There is an example file in the directory to show basic usage. More info is given in `/web/php/system/classes/Config.class.php`. The config file is an unrestricted php file.

## Database
**Easy but unsafe:** Create an empty database and give the database user provided in the config file enough rights to create and modify the tables and the structure is created for you.  
**Save but inconvenient:** Create the database by using `web/dbstruct/dbStruct.sql`.

The programm checks the database structure during every logon and tries to correct if not correspond with the data in `web/dbstruct/dbStruct.inc.php`. Added custom elements (fields, indexes, restraints, etc) are preserved. Custom fieds are moved to the end of the field list. Custom changes to existing fields will be reverted.

## Update
Make a Backup! For update move the current program files out of the way to a backup directory to avoid problems with zombie files. Afterwards follow the instructions in `Install` and move the local config file and the autobackup files to the new install.

For windows there exists the dos-batch file `dev-info/ogerarch-update-windows.bat`, that should handle all for you. Having a backup is up to you.

## Usage
- Create "Stammdaten -> Firma" to be included into pdf-output.
- You can predefine other masterdata too, but everything works fine without. In most cases arbitrary input is possible and the existing input values are provided for selection.
- Be happy &#9786;

## Development
See `dev-info/README-DEV.md`.