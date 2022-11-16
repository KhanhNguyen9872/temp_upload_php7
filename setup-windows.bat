@echo off
cls
echo.
echo 1. Open php.ini file in your client (not php.ini in there) and replace all options like php.ini from there!
echo.
echo 2. Open apache2.conf or httpd.conf, remove the string "Index" to improve security and add "ServerName 0.0.0.0" to the first line of the file!
echo.
echo 3. Start your server and Enjoy!
echo.
pause > NUL