<?php
$file_name = htmlspecialchars( basename( $_FILES["fileToUpload"]["name"]));

// Check if file upload not selected
if ($file_name == "") {
  die("Sorry, you haven't selected a file to upload!");
}

require 'config.php';
require 'check.php';

function random_string() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 20; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$target_dir = $upload_folder . $sym . $date . $sym;

if (!is_dir($upload_folder)) {
  exec($mkdir . $upload_folder . $null_out);
}
if (!is_dir($download_folder)) {
  exec($mkdir . $download_folder . $null_out);
}
if (!is_dir($target_dir)) {
  exec($rm_folder . $upload_folder . $null_out);
  exec($rm_folder . $download_folder . $null_out);
  exec($mkdir . $upload_folder . $null_out);
  exec($mkdir . $download_folder . $null_out);
  exec($mkdir . $target_dir . $null_out);
}

$random = random_string();
$target_dir = $target_dir . $random . $sym;

if (!is_dir($target_dir)) {
  exec($mkdir . $target_dir . $null_out);
}

// Check file size before upload
$size_file = $_FILES["fileToUpload"]["size"];
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

if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
  // Create a download script
  $sd = fopen($target_dir . $sym . "index.php", "w") or die("Cannot create a download script!");
  $txt = "<?php\nheader('Content-Description: File Transfer');\nheader('Content-Type: application/octet-stream');\nheader('Content-Disposition: attachment; filename=\"" . $file_name2 . "\"');\nheader('Content-Transfer-Encoding: binary');\nheader('Connection: Keep-Alive');\nheader('Expires: 0');\nheader('Cache-Control: must-revalidate, post-check=0, pre-check=0');\nheader('Pragma: public');\nheader('Content-Length: " . $size_file . "');\nob_clean();\nflush();\nreadfile(\"" . $file_name . "\");\nexit();\n?>";
  fwrite($sd, $txt);
  fclose($sd);
  // Create a symlink
  if ($win == "0") {
    exec($mk_symlink . ".." . $sym . $target_dir . " " . $download_folder . $sym . $random . $null_out);
  } else {
    exec($mk_symlink . $download_folder . $sym . $random . " .." . $sym . $target_dir . $null_out);
  }
  // Get url for download
  $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  $actual_link = substr($actual_link, 0, strrpos( $actual_link, '/upload.php'));
  //$file_name = rawurlencode($file_name);
  $actual_link = $actual_link . "/" . $download_folder . "/" . $random;
  echo $actual_link;
} else {
  die("Sorry, there was an error uploading your file! Bruh... maybe my code is error ;(");
}
?>
