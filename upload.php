<?php
function random_string($length = 15) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function change_to_txt($filename) {
    return $filename . '.txt';
}
$date = date("Y-m-d");
$upload_folder = "uploads";
$target_dir = $upload_folder. "/". $date. "/";
if (!is_dir($upload_folder)) {
  exec("mkdir ". $upload_folder);
}
if (!is_dir($target_dir)) {
  exec("rm -rf ". $upload_folder."/*; find . -xtype l -delete; mkdir ". $target_dir);
}
$file_name = htmlspecialchars( basename( $_FILES["fileToUpload"]["name"]));
$target_file = $target_dir . $file_name;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if file already exists
if (is_file($target_file)) {
  echo "Sorry, this file already exists! Please rename your file and try again!";
  exit();
}

// Check file size before upload
$size_file = $_FILES["fileToUpload"]["size"];
if ($_FILES["fileToUpload"]["size"] > 268435456) {
  echo "Sorry, this file is too large (". $size_file. " byte)";
  exit();
}

// Change to txt all file formats not allowed
if($imageFileType == "php" || $imageFileType == "html" || $imageFileType == "js" || $imageFileType == "xml" || $imageFileType == "xphp" || $imageFileType == "php5") {
  $file_name = change_to_txt($file_name);
  $target_file = $target_dir . $file_name;
}

if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
  $random = random_string();
  exec("ln -s ". $target_dir. " ". $random);
  $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  $actual_link = substr($actual_link, 0, strrpos( $actual_link, '/upload.php'));
  $file_name = rawurlencode($file_name);
  $actual_link = $actual_link. "/". $random."/". $file_name;
  echo $actual_link;
} else {
  echo "Sorry, there was an error uploading your file! Bruh... maybe my code is error ;(";
}
?>