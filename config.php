<?php
require 'check.php';
// Hostname website
$hostname = "https://temp.run.goorm.io";
// Maximum upload file size (byte)
$max_size_file = 536870912;
// Folder save file upload
$upload_folder = "uploads";
// Folder for user download
$download_folder = "file";
// Date of folder
$date = date("Y-m-d");
// keep file upload, 1 for keep, 0 for delete all in next day!
$keep_file_upload = 0;
// Check Windows or not
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
	$win = "1";
	$null_out = " > NUL 2>&1";
	$rm_folder = "rmdir /q /s ";
	$mkdir = "mkdir ";
	$mk_symlink = "mklink /d ";
	$sym = "\\";
} else {
	$win = "0";
	$null_out = " > /dev/null 2>&1";
	$rm_folder = "rm -rf ";
	$mkdir = "mkdir ";
	$mk_symlink = "ln -s ";
	$sym = "/";
}
?>