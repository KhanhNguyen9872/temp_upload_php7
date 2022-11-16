<?php
require_once 'check.php';
?>
<!DOCTYPE html>
<title>Temp Upload</title>
<html><body>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="UTF-8"/>
<form action="upload.php" method="post" enctype="multipart/form-data">
  <?php
  echo "Select file to upload (Max: ". ini_get('post_max_size'). ")";
  ?>
  <br>
  <input type="file" name="fileToUpload" id="fileToUpload">
  </br><br>
  <input type="submit" value="Upload" name="submit">
  </br>
</form>
</body></html>