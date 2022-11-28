<?php
require 'check.php';
require 'config.php';
?>
<!DOCTYPE html>
<title>Temp Upload</title>
<html><body>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="UTF-8"/>
<form action="upload.php" method="post" enctype="multipart/form-data">
  <?php
  echo "Select file to upload (Max: ". $max_size_file / 1024 . " KB)";
  ?>
  <br>
  <input type="file" name="fileToUpload" id="fileToUpload">
  </br><br>
  <input type="submit" value="Upload" name="submit">
  </br>
</form><br>
<?php
echo "The file will be deleted in the next day!";
?></br><br>
<?php
echo "Server time: " . date('m/d/Y h:i:s a', time());
?>
</br>
<div class="form-group">
  <input type="button" value="Source code Temp Upload" onclick="document.location.href='https://github.com/KhanhNguyen9872/temp_upload_php7'" />
</div></body></html>
