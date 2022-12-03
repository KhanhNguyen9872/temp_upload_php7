<?php
$khanh = $_SERVER['REQUEST_URI'];
if (($khanh == "/config.php") || ($khanh == "/check.php")) {
  require '404.php';
  die();
}
if (phpversion() < 7.0) {
  die("PHP Version too old (" . phpversion() . ")");
}
if (ini_get('file_uploads') != "1") {
  die("File upload has been disabled on the server!");
}
?>