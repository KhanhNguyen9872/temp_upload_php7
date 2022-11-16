<?php
// Maximum upload file size (byte)
$max_size_file = 536870912;
// Folder save file upload
$upload_folder = "uploads";
// Date of folder
$date = date("Y-m-d");
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