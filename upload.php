<?php
error_reporting(0);
$file_name = htmlspecialchars( basename( $_FILES["fileToUpload"]["name"]));

// Check if file upload not selected
if ($file_name == "") {
  die("Sorry, you haven't selected a file to upload!");
}

require 'config.php';

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
  // Get url for download
  $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  $actual_link = substr($actual_link, 0, strrpos( $actual_link, '/upload.php'));
  //$file_name = rawurlencode($file_name);
  $actual_link = $actual_link . "/" . $download_folder . "/" . $random . "/";

  // Create a download script
  $sd = fopen($target_dir . $sym . "index.php", "w") or die("Cannot create a download script!");

  $txt = "<?php\n\$file_name = \"" . $file_name2 . "\";\$finfo = finfo_open(FILEINFO_MIME_TYPE);\$file_type = finfo_file(\$finfo, '" . $file_name . "');finfo_close(\$finfo);\$size = " . $size_file . ";\$check = \$_SERVER['HTTP_USER_AGENT'];\nif (isset(\$_POST['downloadf']) || isset(\$_POST['viewf']) || str_contains(\$check, \"curl\") || str_contains(\$check, \"aria2\") || str_contains(\$check, \"Wget\")) {\nheader('HTTP/1.0 200 OK');\nheader('Accept-Ranges: bytes');\nheader(\"Content-Length: \" . \$size);\nif (isset(\$_POST['downloadf'])) {\nheader('Content-Description: File Transfer');\nheader('Content-Type: application/octet-stream');\nheader('Content-Disposition: attachment; filename=\"" . $file_name . "\"');\nheader('Content-Transfer-Encoding: binary');\nheader('Connection: Keep-Alive');\nheader('Expires: 0');\nheader('Cache-Control: must-revalidate, post-check=0, pre-check=0');\nheader('Pragma: public');\n} else {\nheader('Content-Disposition: inline');\nheader(\"Content-Type: \" . \$file_type);\n};\nif(ob_get_length() > 0) {ob_clean();}\nflush();\nreadfile(\$file_name);\nexit();\n}\n?>\n<!DOCTYPE html><meta name=\"viewport\" content=\"width=device-width, initial-scale=1\"><meta charset=\"UTF-8\"/><html><head><?php\necho \"<title>\" . \$file_name . \"</title>\";\n?>\n</head><body><?php\necho \"<h1>\" . \$file_name . \"</h1>\";\necho \"<p>Type: \" . \$file_type . \"</p>\";\necho \"<p>Size: \" . round(\$size / 1024) . \" KB</p>\";\n?>\n<form method=\"post\"><input type=\"submit\" name=\"viewf\" value=\"View file\" onclick=\"\" /><input type=\"submit\" name=\"downloadf\" value=\"Download\" onclick=\"\" /></form></body></html>";

  fwrite($sd, $txt);
  fclose($sd);
  // Create a symlink
  if ($win == "0") {
    exec($mk_symlink . ".." . $sym . $target_dir . " " . $download_folder . $sym . $random . $null_out);
  } else {
    exec($mk_symlink . $download_folder . $sym . $random . " .." . $sym . $target_dir . $null_out);
  }
  echo $actual_link;
} else {
  die("Sorry, there was an error uploading your file! Bruh... maybe my code is error ;(");
}
?>
