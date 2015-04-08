@echo off
setlocal EnableDelayedExpansion

set DB_USER=phuckhang
set DB_PASS=phuckhang
set DB_NAME=phuckhang
set DB_HOST=localhost
set MYSQL_DIR=D:/tools/wamp/bin/mysql/mysql5.6.12/bin/
echo =========================================================
echo db_user is %DB_USER%
echo db_pass is %DB_PASS%
echo db_name is %DB_NAME%
echo db_host is %DB_HOST% 

set WORKING_FOLDER=%~dp0
cd /d %WORKING_FOLDER%

set /a FILE_COUNTER = 1
echo =========================================================
set SCRIPT_FILE_PATTERN=*_*.sql
for /f "tokens=*" %%f IN ('dir /b *.sql') do (
    echo !FILE_COUNTER!. Start loading file %%f...
    %MYSQL_DIR%mysql --host=%DB_HOST% --user=%DB_USER% --password=%DB_PASS% %DB_NAME% < "%%f"
    set /a FILE_COUNTER = !FILE_COUNTER! + 1
)

:End
echo =========================================================
echo FINISHED!
pause