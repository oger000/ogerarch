@ECHO OFF
CLS

ECHO .
ECHO Aktuelles Verzeichnis ist
ECHO %CD%
ECHO .

ECHO .
ECHO      *****************************
ECHO      *** START OGERARCH UPDATE ***
ECHO      *****************************
ECHO .
ECHO .
ECHO      *********************************
ECHO      * EXPORT/BACKUP NICHT VERGESSEN *
ECHO      *********************************
ECHO .
PAUSE


REM installations archiv muss vorhanden sein
IF NOT EXIST ogerarch-dist.sfx GOTO NO_SFX

REM .exe (sfx-exe) kann geloescht werden, weil weiter oben
REM bereits geprueft wurde, ob eine neue .sfx vorhanden ist
IF EXIST ogerarch-dist.exe DEL ogerarch-dist.exe


REM standard installations verzeichnis
SET DOC_ROOT=C:\xampp\htdocs


REM erster startparameter ist alternatives installationsverzeichnis (wenn nicht leer)
IF NOT "%1"=="" SET DOC_ROOT=%1


REM alternatives installationsverzeichnis abfragen
ECHO .
ECHO Aktueller Pfad zum Document Root Verzeichnis ist
ECHO %DOC_ROOT%
ECHO Entweder neuen Pfad eingeben, oder einfach die
ECHO [ENTER]-Taste druecken um den aktuellen Pfad zu behalten.
ECHO .
SET /P INPUT=Neuer Pfad zum Document Root Verzeichnis:
IF NOT "%INPUT%"=="" SET DOC_ROOT=%INPUT%


REM pruefeon ob document root vorhanden ist
IF NOT EXIST %DOC_ROOT% GOTO NO_DOCROOT


SET APP_DIR=%DOC_ROOT%\ogerarch
SET WEB_DIR=%APP_DIR%\web
SET BAKDIR0=%DOC_ROOT%\ogerarch-bak_
SET BAK_POST=%DATE%
SET BAK_DIR=%BAKDIR0%%BAK_POST%

REM bestehendes programmverzeichnis nur sichern/loeschen, wenn vorhanden
IF NOT EXIST %APP_DIR% GOTO DO_UPDATE

GOTO INP_BAK

:BAK_EXIST
ECHO .
ECHO      ***********************************************
ECHO      BACKUP VERZEICHNIS EXISTIERT BEREITS
ECHO      BITTE NICHT EXISTENTES ZIELVERZEICHNIS ANGEBEN
ECHO      ***********************************************
ECHO .

:INP_BAK
DIR %BAKDIR0%*

ECHO .
ECHO Aktuelle Installation wird gesichert nach
ECHO Basis  : %BAKDIR0%
ECHO Postfix: %BAK_POST%
ECHO Pfad   : %BAK_DIR%
ECHO .
ECHO [ENTER]-Taste druecken um den Vorschlag zu uebernehmen
ECHO oder ein eigenes/geaendertes Postfix angeben
ECHO .
SET /P INPUT=Postfix:
IF NOT "%INPUT%"=="" SET BAK_DIR=%BAKDIR0%%INPUT%

REM backup ziel darf nicht existieren
IF EXIST %BAK_DIR% GOTO BAK_EXIST

ECHO .
ECHO Sicherungskopie erstellen (XCOPY)
ECHO QUEL: %APP_DIR%
ECHO ZIEL: %BAK_DIR%
ECHO .
PAUSE
ECHO .
ECHO XCOPY startet
ECHO .
REM XCOPY: /Z soll progressbar anzeigen?
XCOPY %APP_DIR% %BAK_DIR% /E /I /H /-Y /Z

ECHO .
ECHO Altes ogerarch in %APP_DIR% wird geloescht - bitte warten.
ECHO .

REM DEL /Q %APP_DIR%\*.*

RMDIR /S /Q %APP_DIR%\docu
RMDIR /S /Q %APP_DIR%\dist-dev

DEL %WEB_DIR%\*.php
DEL %WEB_DIR%\*.html
DEL %WEB_DIR%\*.txt
DEL %WEB_DIR%\*.sh

RMDIR /S /Q %WEB_DIR%\classes
RMDIR /S /Q %WEB_DIR%\common
RMDIR /S /Q %WEB_DIR%\dbstruct
RMDIR /S /Q %WEB_DIR%\help
RMDIR /S /Q %WEB_DIR%\img
RMDIR /S /Q %WEB_DIR%\js
RMDIR /S /Q %WEB_DIR%\pdftemplates
RMDIR /S /Q %WEB_DIR%\php
RMDIR /S /Q %WEB_DIR%\migrate

RMDIR /S /Q %WEB_DIR%\lib
REM RMDIR /S /Q %WEB_DIR%\lib\extjs4
REM RMDIR /S /Q %WEB_DIR%\lib\ogerlibjs
REM RMDIR /S /Q %WEB_DIR%\lib\ogerlibjs12
REM RMDIR /S /Q %WEB_DIR%\lib\ogerlibphp
REM RMDIR /S /Q %WEB_DIR%\lib\ogerlibphp12
REM RMDIR /S /Q %WEB_DIR%\lib\tcpdf
REM ein zweitesmal um auch struktur zu entfernen
RMDIR /S /Q %WEB_DIR%\lib


REM pruefen, ob datei reste vorhanden sind
ECHO .
ECHO ***********************************************************************
ECHO *
ECHO *   Bitte das Loeschen der altem ogerarch Installation ueberpruefen.
ECHO *   Liste der verbliebenen Dateien wird erstellt.
ECHO *
ECHO ***********************************************************************
ECHO .

DIR %WEB_DIR%
PAUSE


:DO_UPDATE
REM .sfx and .exe wurden weiter oben geprueft
ECHO .
ECHO     Neues ogerarch wird eingespielt.
ECHO .
RENAME ogerarch-dist.sfx ogerarch-dist.exe
ogerarch-dist.exe -o -d %DOC_ROOT%
RENAME ogerarch-dist.exe ogerarch-dist.sfx

IF NOT EXIST %APP_DIR% GOTO NO_NEWAPP

ECHO .
ECHO .
ECHO      **********************************
ECHO      *** UPDATE ERFOLGREICH BEENDET ***
ECHO      **********************************
ECHO .
PAUSE
EXIT


REM ===================================================================

:NO_SFX
ECHO .
ECHO      **************************
ECHO      *** UPDATE ABGEBROCHEN ***
ECHO      **************************
ECHO .
ECHO Kein Installations-Archiv (ogerarch-dist.sfx) gefunden.
ECHO .
PAUSE
EXIT


:NO_DOCROOT
ECHO .
ECHO      **************************
ECHO      *** UPDATE ABGEBROCHEN ***
ECHO      **************************
ECHO .
ECHO Document Root %DOC_ROOT% nicht gefunden.
ECHO .
PAUSE
EXIT


:NO_RMAPP
ECHO .
ECHO      **************************
ECHO      *** UPDATE ABGEBROCHEN ***
ECHO      **************************
ECHO .
ECHO Verzeichnis %APP_DIR% konnte nicht entfert werden:
DIR /S /B %APP_DIR%
ECHO Bitte ueberpruefen und Update neu starten.
ECHO .
PAUSE
EXIT


:NO_NEWAPP
ECHO .
ECHO      **************************
ECHO      *** UPDATE ABGEBROCHEN ***
ECHO      **************************
ECHO .
ECHO *** Update fehlgeschlagen (%APP_DIR% wurde nicht erstellt).
ECHO .
PAUSE
EXIT
