<?php
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    echo 'This project is not supported Windows!';
    exit();
}
if (ini_get('file_uploads') != "1") {
  echo "File upload has been disabled on the server!";
  exit();
}
?>