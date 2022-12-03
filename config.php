<?php
require 'check.php';
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
// Check config if not null
if ($download_folder == "") {
  die("Download folder in config is null!");
}
if ($upload_folder == "") {
  die("Upload folder in config is null!");
}
if ($max_size_file == "") {
  die("Size file in config is null!");
}
if ($date == "") {
  die("Date in config is null!");
}
?>
