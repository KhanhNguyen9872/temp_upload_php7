<!DOCTYPE html>
<html>
<body>

<form action="upload.php" method="post" enctype="multipart/form-data">
  <?php
  echo "Select image to upload (Max: ". ini_get('post_max_size'). ")";
  ?>
  <br>
  <input type="file" name="fileToUpload" id="fileToUpload">
  </br><br>
  <input type="submit" value="Upload" name="submit">
  </br>
</form>

</body>
</html>
