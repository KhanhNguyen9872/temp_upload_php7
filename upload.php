<?php
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
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
if (file_exists($target_file)) {
  echo "Sorry, [". $file_name. "] already exists! Please rename your file and try again!";
  exit();
}

// Check file size before upload
$size_file = $_FILES["fileToUpload"]["size"];
if ($_FILES["fileToUpload"]["size"] > 134217800) {
  echo "Sorry, ". $file_name. " is too large (". $size_file. " byte)";
  exit();
}

// File format not allowed
if($imageFileType == "php" || $imageFileType == "html" || $imageFileType == "css" || $imageFileType == "js" || $imageFileType == "xml" || $imageFileType == "xphp" || $imageFileType == "php5") {
  echo "Sorry, CSS, PHP, JS, HTML, XML, XPHP, PHP5 files are not allowed.";
  exit();
}

if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
  $random = generateRandomString();
  exec("ln -s ". $target_dir. " ". $random);
  $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  $actual_link = substr($actual_link, 0, strrpos( $actual_link, '/upload.php'));
  echo $actual_link. "/". $random."/". $file_name;
} else {
  echo "Sorry, there was an error uploading your file!";
}
?>
