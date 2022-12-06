<?php
// Get IP Public from user
$ip = $_SERVER['REMOTE_ADDR'];
$get_type = $_SERVER['REQUEST_METHOD'];
if (($get_type == "GET") || ($get_type == "POST")) {
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
} else {
  require '405.php';
  die();
}
unset($get_type,$khanh);
?>