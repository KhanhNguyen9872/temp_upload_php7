<?php
if (ini_get('file_uploads') != "1") {
  echo "File upload has been disabled on the server!";
  exit();
}
?>