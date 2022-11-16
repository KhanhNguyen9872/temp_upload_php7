@echo off
cls
echo.
echo 1. Open php.ini file in your client (not php.ini in there) and replace all options like php.ini from there!
echo.
echo 2. Open apache2.conf or httpd.conf, remove the string "Index" to improve security and add "ServerName 0.0.0.0" to the first line of the file!
echo.
echo 3. Remove install file (php.ini, setup.sh, README.md, README.png, LICENSE, setup-windows.bat)
echo.
echo 4. Start your server and Enjoy!
echo.
pause > NUL
