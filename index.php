<?php
error_reporting(0);
$target_dir = $upload_folder . $sym . $date . $sym;
if (!is_dir($upload_folder)) {
  exec($mkdir . $upload_folder . $null_out);
}
if (!is_dir($target_dir)) {
  exec($rm_folder . $download_folder . $null_out);
  exec($mkdir . $download_folder . $null_out);
  if ($keep_file_upload == 0) {
    exec($rm_folder . $upload_folder . $null_out);
    exec($mkdir . $upload_folder . $null_out);
  }
  exec($mkdir . $target_dir . $null_out);
}
require 'config.php';
$file_name = htmlspecialchars( basename( $_FILES["file"]["name"]));

// Check if file upload not selected
if ($file_name != "") {
  function random_string() {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < 20; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
  }
  if (!is_dir($download_folder)) {
    exec($mkdir . $download_folder . $null_out);
  }
  $random = random_string();
  $target_dir = $target_dir . $random . $sym;

  if (!is_dir($target_dir)) {
    exec($mkdir . $target_dir . $null_out);
  }

  // Check file size before upload
  $size_file = $_FILES["file"]["size"];
  if ($size_file > $max_size_file) {
    die("Sorry, this file is too large (". $size_file. " byte)");
  }

  $file_name2 = $file_name;
  $target_file = $target_dir . $file_name;
  $FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

  // Rename to txt if file is unsupported type
  if ($FileType == "php" || $FileType == "html" || $FileType == "js" || $FileType == "xml" || $FileType == "css" || $FileType == "json") {
    $file_name = $file_name . '.txt';
  }

  $target_file = $target_dir . $file_name;

  // Check if file already exists
  if (is_file($target_file)) {
    die("Sorry, this file already exists! Please rename your file and try again!");
  }

  if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
    // Get url for download
    $actual_link = $hostname . "/" . $download_folder . "/" . $random . "/";
    $actual_link = str_replace("//","/",$actual_link);

    // Create a download script
    $sd = fopen($target_dir . $sym . "index.php", "w") or die("Cannot create a download script!");
    $finfo=finfo_open(FILEINFO_MIME_TYPE);
    $file_type=finfo_file($finfo,$target_file);
    finfo_close($finfo);
    $txt = "<?php\n\$z=\$_SERVER['DOCUMENT_ROOT'];require \"\".\$z.\"".$sym."config.php\";error_reporting(0);function check_sw(){\$check=\$_SERVER['HTTP_USER_AGENT'];if((strpos(\$check,\"curl\")!==false)||(strpos(\$check,\"aria2\")!==false)||(strpos(\$check,\"Wget\")!==false)){return 1;};return 0;};\$file_name=\"" . $file_name . "\";\$file_name2=\"" . $file_name2 . "\";\$file_type=\"". $file_type ."\";\$size=" . $size_file . ";\$sw=check_sw();if(isset(\$_POST['downloadf'])||isset(\$_POST['viewf'])||\$sw==1){header('HTTP/1.0 200 OK');header('Accept-Ranges: bytes');header(\"Content-Length: \".\$size);if(isset(\$_POST['downloadf'])||\$sw==1){\$type=\"Download\";header('Content-Description: File Transfer');header('Content-Type: application/octet-stream');header('Content-Disposition: attachment; filename=\"" . $file_name2 . "\"');header('Content-Transfer-Encoding: binary');header('Connection: Keep-Alive');header('Expires: 0');header('Cache-Control: must-revalidate, post-check=0, pre-check=0');header('Pragma: public');}else{\$type=\"View\";header('Content-Disposition: inline');if(\$file_type==\"text/html\") {\$file_type=\"text/plain\";};header(\"Content-Type: \".\$file_type);};if(ob_get_length()>0){ob_clean();};flush();readfile(\$file_name);if(\$islog==1){if(!is_dir(\$z.\$sym.\$log_folder)){exec(\$mkdir.\$z.\$sym.\$log_folder.\$null_out);};\$sd=fopen(\$z.\$sym.\$log_folder.\$sym.date('m-d-Y',time()).\".log\",\"a\");fwrite(\$sd,\"[\".date('d/m/Y h:i:s a',time()).\"] (\".\$ip.\") \".\$type.\": {\\\"\".\$file_name2.\"\\\", \\\"\".\$size.\" byte\\\", \\\"" . $random . "\\\", \\\"\".\$file_type.\"\\\"}\\n\");fclose(\$sd);};die();}?><!DOCTYPE html><meta name=\"viewport\"content=\"width=device-width,initial-scale=1\"><meta charset=\"UTF-8\"/><html><head><?php\necho \"<title>\".\$file_name2.\"</title></head><body>\";echo \"<h1>\".\$file_name2.\"</h1>\";echo \"<p>Type: \".\$file_type.\"</p>\";echo \"<p>Size: \".round(\$size / 1024).\" KB</p>\";?><form method=\"post\"><input type=\"submit\"name=\"viewf\"value=\"View file\"onclick=\"\"/><input type=\"submit\"name=\"downloadf\"value=\"Download\"onclick=\"\"/></form></body></html>";
    fwrite($sd, $txt);
    fclose($sd);
    // Create a symlink
    if ($win == "0") {
      exec($mk_symlink . ".." . $sym . $target_dir . " " . $download_folder . $sym . $random . $null_out);
    } else {
      exec($mk_symlink . $download_folder . $sym . $random . " .." . $sym . $target_dir . $null_out);
    }
    echo $actual_link;
    // Get log
    if ($islog == 1) {
      if (!is_dir($log_folder)) {
        exec($mkdir . $log_folder . $null_out);
      }
      $sd = fopen($log_folder . $sym . date('m-d-Y', time()) . ".log", "a");
      fwrite($sd, "[" . date('d/m/Y h:i:s a', time()) . "] (" . $ip . ") Upload: {\"" . $file_name2 . "\", \"" . $size_file . " byte\", \"" . $random . "\", \"" . $file_type . "\"}\n");
      fclose($sd);
    }
  } else {
    die("Sorry, there was an error uploading your file! Bruh... maybe my code is error ;(");
  }
  die();
}
?>
<!DOCTYPE html>
<title>Temp Upload</title>
<html><body>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="UTF-8"/>
<form action="" method="post" enctype="multipart/form-data">
  <?php
  echo "Select file to upload (Max: ". round($max_size_file / 1024) . " KB)";
  ?>
  <br>
  <input type="file" name="file" id="file">
  </br><br>
  <input type="submit" value="Upload" name="submit">
  </br>
</form><br>
The file will be deleted in the next day!
</br><br>
<?php
echo "Server time: " . date('d/m/Y h:i:s a', time()) . "</br>IP: " . $ip;
?>
<div class="form-group">
  <input type="button" value="Source code Temp Upload" onclick="document.location.href='https://github.com/KhanhNguyen9872/temp_upload_php7'" />
</div>
<script>
document.forms[0].addEventListener('submit', function( evt ) {
    var file = document.getElementById('file').files[0];
    <?php
    echo "if (file && file.size > " . $max_size_file . ") {evt.preventDefault();}"
    ?>
}, false);
</script></body></html>