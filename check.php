<?php
$khanh = $_SERVER['REQUEST_URI'];
if (($khanh == "/config.php") || ($khanh == "/check.php") {
  header("Location: " . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]");
  die();
}
if (phpversion() < 7.0) {
  die("PHP Version too old (" . phpversion() . ")");
}
if (ini_get('file_uploads') != "1") {
  die("File upload has been disabled on the server!");
}
require 'config.php';
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