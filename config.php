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
// keep file upload 
// 0 for Disable, 
// 1 for Keep file from [upload_folder], but link download will be removed
// 2 for Keep file from [upload_folder] and keep link download
$keep_file_upload = 0;
// get log from upload and download (0 for FALSE, 1 for TRUE)
$islog = 0;
// Folder for save log
$log_folder = "log";
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
$z=$_SERVER['DOCUMENT_ROOT'];
if (!is_dir($z . $sym . $upload_folder)) {
  exec($mkdir . $z . $sym . $upload_folder . $null_out);
}
$target_dir = $upload_folder . $sym . $date . $sym;
if (!is_dir($z . $sym . $target_dir)) {
	if (($keep_file_upload == 0) && ($keep_file_upload == 1)) {
		exec($rm_folder . $z . $sym . $download_folder . $null_out);
  	exec($mkdir . $z . $sym . $download_folder . $null_out);
	}
  if ($keep_file_upload == 0) {
    exec($rm_folder . $z . $sym . $upload_folder . $null_out);
    exec($mkdir . $z . $sym . $upload_folder . $null_out);
  }
  exec($mkdir . $z . $sym . $target_dir . $null_out);
  header("refresh: 0");
}
?>