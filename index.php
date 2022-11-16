<?php
  $upload = ini_get('file_uploads');
  if ($upload != "1") {
    echo "File upload has been disabled on the server!";
    exit();
  }
?>
<!DOCTYPE html>
<html><body>
<meta name="viewport" content="width=device-width, initial-scale=2">
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