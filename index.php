<?php
error_reporting(0);
require 'config.php';
$_alert=null;
$file_name=htmlspecialchars(basename($_FILES["file"]["name"]));

// Check if file upload not selected
if($file_name!=""){
  if(!is_dir($download_folder)){exec($mkdir.$download_folder.$null_out);};
  $random=random_string();
  $target_dir=$target_dir.$random.$sym;

  if(!is_dir($target_dir)){exec($mkdir.$target_dir.$null_out);};

  // Check file size before upload
  $size_file=$_FILES["file"]["size"];
  if($size_file>$max_size_file){die("Sorry, this file is too large (".$size_file." byte)");};

  $file_name2=$file_name;
  $target_file=$target_dir.$file_name;
  $FileType=strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  $file_name=random_string(30).".".$FileType;
  // Rename to txt if file is unsupported type
  if($FileType=="php"||$FileType=="html"||$FileType=="js"||$FileType=="xml"||$FileType=="css"||$FileType=="json"){$file_name=$file_name.'.txt';};
  $target_file=$target_dir.$file_name;
  // Check if file already exists
  if(is_file($target_file)){
    die("Sorry, this file already exists! Please rename your file and try again!");
  };
  $sw=check_sw();
  if(move_uploaded_file($_FILES["file"]["tmp_name"],$target_file)){
    // Get url for download
    $actual_link=$hostname."/".$download_folder."/".$random."/";

    // Create a download script
    $sd=fopen($target_dir.$sym."index.php","w") or die("Cannot create a download script!");
    $finfo=finfo_open(FILEINFO_MIME_TYPE);
    $file_type=finfo_file($finfo,$target_file);
    finfo_close($finfo);
    $_image="data:image/jpg;base64,".base64_encode(file_get_contents("https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=".rawurlencode($actual_link)));
    $key_del=random_string(15);
    $txt="<?php error_reporting(0);\$z=\$_SERVER['DOCUMENT_ROOT'];require \"\".\$z.\"".$sym."config.php\";\$z=str_replace(\$sym1,\$sym,\$z);\$alert=null;\$random_str=\"".$random."\";\$key_del=\"".$key_del."\";\$sw=check_sw();if(isset(\$_POST[\"del\"])){if(\$_POST[\"del\"]==\$key_del){\$v=1;exec(\$rm_folder.\$z.\$sym.\$download_folder.\$sym.\$random_str.\$null_out);exec(\$rm_folder.\$z.\$sym.\$upload_folder.\$sym.\"".$date."\".\$sym.\$random_str.\$null_out);\$type=\"Delete\";echo(\"DELETED!\");}else{\$v=0;if(\$sw==1){\$v=1;if(\$_POST[\"del\"]!=\"\"){echo(\"KEY ERROR\");}else{die();};}else{if(\$_POST[\"del\"]!=\"\"){\$alert=\"KEY ERROR\";}else{\$v=0;};};};}else{\$v=0;};\$file_name=\"".$file_name."\";\$file_name2=\"".$file_name2."\";\$file_type=\"".$file_type."\";\$size=".$size_file.";if(isset(\$_POST['downloadf'])||\$v==1||isset(\$_POST['viewf'])||\$sw==1){if(\$v==0){if((isset(\$_POST['viewf']))&&((strpos(\$file_type,\"video/\")!==false)||(strpos(\$file_type,\"audio/\")!==false))){header(\"Location: \".\$hostname.\"/\".\$download_folder.\"/\".\$random_str.\"/\".rawurlencode(\$file_name));die();};header('HTTP/1.0 200 OK');header('Accept-Ranges: bytes');header(\"Content-Length: \".\$size);if(isset(\$_POST['downloadf'])||\$sw==1){\$type=\"Download\";header('Content-Description: File Transfer');header('Content-Type: application/octet-stream');header('Content-Disposition: attachment; filename=\"".$file_name2."\"');header('Content-Transfer-Encoding: binary');header('Connection: Keep-Alive');header('Expires: 0');header('Cache-Control: must-revalidate, post-check=0, pre-check=0');header('Pragma: public');}else{\$type=\"View\";header('Content-Disposition: inline');if(\$file_type==\"text/html\"){\$file_type=\"text/plain\";};header(\"Content-Type: \".\$file_type);};if(ob_get_length()>0){ob_clean();};flush();readfile(\$file_name);};write_log(\$z,\$islog,\$log_folder,\$mkdir,\$null_out,\$sym,\$ip,\$type,\$file_name2,\$size,\$random_str,\$file_type);die();}else{\$up_time=\"".date('d/m/Y h:i:s a', time())."\";\$up_device=\"".gethostname()."\";}; ?><!doctype html><html class=\"no-js\"><head><meta charset=\"utf-8\"><meta http-equiv=\"X-UA-Compatible\"content=\"IE=edge\"><?php echo \"<title>\".\$file_name2.\"</title>\"; ?><meta name=\"description\"content=\"Easy and fast file sharing from the command-line.\"><meta name=\"viewport\"content=\"width=device-width, initial-scale=1.0\"><link rel=\"stylesheet\"href=\"/src/styles/main.css\"><link href='/src/styles/droid_sans_mono.css'rel='stylesheet'type='text/css'><link href='/src/styles/source_sans_pro.css'rel='stylesheet'type='text/css'></head><body id=\"download\"><div id=\"navigation\"><div class=\"wrapper\"><a href=\"/\"><h1>Temp Upload</h1></a><ul class=\"hidden-xs\"><li><a href=\"/#\">Home</a></li><li><a href=\"/#samples\">Sample use cases</a></li></ul></div></div><section id=\"home\"><div class=\"wrapper\"><br/><h2 class=\"page-title\"><b><?php echo \$file_name2; ?></b></h2><h4>Upload time: <b><?php echo \$up_time.\" (".date_default_timezone_get().")\"; ?></b></h4><h4>Upload device: <b><?php echo \$up_device; ?></b></h4><h4>Type: <b><?php echo \$file_type; ?></b></h4><h4>Size: <b><?php echo round(\$size / 1024); ?> KB</b></h4><form method=\"post\"><input type=\"submit\"class=\"btn-cta btn\"name=\"viewf\"value=\"View file\"onclick=\"\"/><br/><br/><input type=\"submit\"class=\"btn-cta btn\"name=\"downloadf\"value=\"Download\"onclick=\"\"/><br/><br/></form><div class=\"qrcode\"><img src=\"".$_image."\"/></div><br/><div id=\"from-terminal\"class=\"box col-md-8 col-md-offset-2 col-xs-12\"><div class=\"terminal-top\"></div><div class=\"terminal\"><div id=\"web\"><form action=\"\"method=\"post\"enctype=\"multipart/form-data\"><input type=\"text\"id=\"del\"name=\"del\"value=\"\"placeholder=\"KEY\"><input type=\"submit\"value=\"DELETE\"id=\"delete\"class=\"btn-cta btn\"></i> </a> <br/><br/></form><?php if(\$alert!=null){echo(\$alert);}; ?></div></div></div><br/></div></section><a href=\"https://github.com/KhanhNguyen9872/temp_upload_php7/\"><img style=\"position: absolute; top: 0; right: 0; border: 0;\" src=\"/src/images/fork.png\" alt=\"Fork me on GitHub\" data-canonical-src=\"/src/images/fork.png\"></a></body></html>";
    fwrite($sd,$txt);
    fclose($sd);
    // Create a symlink
    if($win=="0"){exec($mk_symlink."..".$sym.$target_dir." ".$download_folder.$sym.$random.$null_out);}else{exec($mk_symlink.$download_folder.$sym.$random." ..".$sym.$target_dir.$null_out);};
    // Get log
    write_log($z,$islog,$log_folder,$mkdir,$null_out,$sym,$ip,"Upload",$file_name2,$size_file,$random,$file_type);
  }else{die("Sorry, there was an error uploading your file! Bruh... maybe my code is error ;(");};
  if($sw==1){die($actual_link."     ".$key_del);}else{$_alert=$actual_link;};};
?><!doctype html><html class="no-js"><head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible"content="IE=edge"><title>Temp Upload</title><meta name="description"content="Easy and fast file sharing from the command-line."><meta name="viewport"content="width=device-width, initial-scale=1.0"><link rel="stylesheet"href="/src/styles/main.css"><link href='/src/styles/droid_sans_mono.css'rel='stylesheet'type='text/css'><link href='/src/styles/source_sans_pro.css'rel='stylesheet'type='text/css'></head><body><div id="navigation"><div class="wrapper"><a href="/"><h1>Temp Upload</h1></a><ul class="hidden-xs"><li><a href="#">Home</a></li><li><a href="#samples">Sample use cases</a></li></ul></div></div>
<section id="home">
    <div class="wrapper">
        <h2 class="page-title">
            Easy file sharing from the command line</h2>
        <div class="row animated fadeInDown">
            <div id="from-terminal" class="box col-md-8 col-md-offset-2 col-xs-12">
                <div class="terminal-top">
                </div>
                <div id="terminal" class="terminal">
                    <code class="code-wrapper"><span class="code-title"># Upload using cURL</span>
                        $ curl -F "file=@hello.txt" <?php echo $hostname."<br>>> ".$hostname; ?>/file/G3Nl4iZ/     AABBCC11<br><span class="code-title"># Using the shell function</span>
                        $ temp hello.txt <br><?php echo ">> ".$hostname; ?>/file/G3Nl4iZ/     AABBCC11<br><span class="code-title"># Delete file using cURL</span>
                        $ curl -F "del=AABBCC11" <?php echo $hostname; ?>/file/G3Nl4iZ/<br>>> DELETED!
                    </code>
                </div>
                <div id="web">
                    <code class="code-wrapper">
                        <span class="code-title"># Upload from web</span>
                        <?php if(($keep_file_upload==0)||($keep_file_upload==1)){echo "<br>The file will be deleted in the next day!";};echo "<br>Server time: ".date('d/m/Y h:i:s a', time())." (".date_default_timezone_get().")"."</br>IP: ".$ip; ?>
                        <form action="" method="post" enctype="multipart/form-data">
                            <?php echo "Select file to upload (Max: ".round($max_size_file / 1024)." KB)"; ?>
                            <input type="file" name="file" id="file">
                            <input type="submit" value="Upload" name="submit">
                        </form>
                        <?php if($_alert!=null){echo "<span class=\"code-title\">>> Uploaded: ".$file_name2."</span><br>".$_alert."<br><td><button onclick=\"copy(0)\">Copy link</button><button onclick=\"new_()\">Open in new tab</button></td><div class=\"qrcode\"><img src=\"".$_image."\"/></div><br><span class=\"code-title\">>> Key DELETE: ".$key_del."</span><br><button onclick=\"copy(1)\">Copy KEY</button>";}; ?>
                    </code>
                </div>
            </div>
        </div>
</section>
<section id="samples">
    <div class="wrapper">
        <h2 class="page-title">
            Sample use cases
        </h2>
        <div class="row">
            <div class="col-md-6 ">
                <h3>How to upload/Download/Delete</h3>
                <div class="terminal-top">
                </div>
                <div class="terminal">
                    <code class="code-wrapper"><span class="code-title"># Uploading is easy using curl</span>
                        $ curl -F "file=@hello.txt" <?php echo ">> ".$hostname."<br>>> ".$hostname; ?>/file/G3Nl4iZ/     AABBCC11</br>
                        <span class="code-title"># Download the file</span>
                        $ curl <?php echo $hostname; ?>/file/G3Nl4iZ/ -o hello.txt<br>
                        <span class="code-title"># Delete the file</span>
                        $ curl -F "del=AABBCC11" <?php echo $hostname; ?>/file/G3Nl4iZ/<br>>> DELETED!
                    </code>
                </div>
            </div>
            <div class="col-md-6 ">
                <h3>Add shell function to .bashrc or .zshrc</a></h3>
                <div class="terminal-top">
                </div>
                <div class="terminal">
                    <code class="code-wrapper"><span class="code-title"># Add this to .bashrc or .zshrc or its equivalent</span>
                        temp(){ if [ $# -eq 0 ]; then echo "Use: temp [file]"; else if [[ $1 == "del" ]]; then if [ $# -eq 3 ]; then curl -F "del=$2" $3;else echo "temp del [key-file] [link-file]";return;fi ;else if [ -f "$@" ]; then curl -F "file=@$@" <?php echo $hostname ?>; else if [ -d "$@" ]; then echo "$1 must be a file! not a folder!"; else echo "$1 not found!";fi;fi;fi;fi }

                        <span class="code-title"># Now you can use temp function</span>
                        $ temp hello.txt
                        <?php echo ">> ".$hostname; ?>/file/G3Nl4iZ/     AABBCC11<br>
                        <span class="code-title"># Delete file using temp function</span>
                        $ temp del AABBCC11 <?php echo $hostname; ?>/file/G3Nl4iZ/<br>>> DELETED!
                    </code>
                </div>
            </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <h3>Encrypt your files with openssl before upload</h3>
              <div class="terminal-top">
              </div>
              <div class="terminal">
                  <code class="code-wrapper"><span class="code-title"># Encrypt files with password using openssl</span>
                      $ cat hello.txt|openssl aes-256-cbc -pbkdf2 -e|curl -F "file=@-" <?php echo $hostname; ?><br><?php echo ">> ".$hostname; ?>/file/G3Nl4iZ/     AABBCC11<br>
                      <span class="code-title"># Download and decrypt</span>
                      $ curl <?php echo $hostname; ?>/file/G3Nl4iZ/|openssl aes-256-cbc -pbkdf2 -d > hello.txt
                  </code>
              </div>
          </div>
          <div class="col-md-6">
            <h3>Upload a file in Windows</h3>
            <div class="terminal-top">
            </div>
            <div class="terminal">
              <code class="code-wrapper"><span class="code-title"># Save this as temp.cmd in Windows 10/11 (which has curl.exe)</span>
@echo off
setlocal EnableDelayedExpansion EnableExtensions
goto main
:usage
echo No arguments specified. >&2
echo Usage: >&2
echo temp ^<file^|directory^> >&2
echo ... ^| temp ^<file_name^> >&2
exit /b 1
:main
if "%~1" == "" goto usage
timeout.exe /t 0 >nul 2>nul || goto not_tty
set "file=%~1"
for %%A in ("%file%") do set "file_name=%%~nxA"
if exist "%file_name%" goto file_exists
echo %file%: No such file or directory >&2
exit /b 1
:file_exists
if not exist "%file%\" goto not_a_directory
set "file_name=%file_name%.zip"
pushd "%file%" || exit /b 1
set "full_name=%temp%\%file_name%"
powershell.exe -Command "Get-ChildItem -Path.-Recurse | Compress-Archive -DestinationPath ""%full_name%"""
curl.exe --form "file=@%full_name%" "<?php echo $hostname;
?>"
popd
goto :eof
:not_a_directory
curl.exe --form "file=@%file%" "<?php echo $hostname;
?>"
goto :eof
:not_tty
set "file_name=%~1"
curl.exe --form "file=@-" "<?php echo $hostname;
?>"
goto :eof
            <br><span class="code-title"># Now you can use temp function</span>
              C:\Users\KhanhNguyen9872>temp.cmd hello.txt<?php echo "<br>>> ".$hostname; ?>/file/G3Nl4iZ/     AABBCC11</code></div></div></div></div></section><a href="https://github.com/KhanhNguyen9872/temp_upload_php7/"><img style="position: absolute; top: 0; right: 0; border: 0;" src="/src/images/fork.png" alt="Fork me on GitHub" data-canonical-src="/src/images/fork.png"></a><script>function new_(){window.open("<?php echo $_alert; ?>","_blank");};function copy(aa){if(aa === 0){<?php echo "var text=\"".$_alert."\";"; ?>}else if(aa === 1){<?php echo "var text=\"".$key_del."\";"; ?>}else{<?php echo "var text=\"KhanhNguyen9872\";" ?>};navigator.clipboard.writeText(text).then(() => {alert("Copied: "+text);}).catch(() => {alert("Cannot copy link!");});};document.forms[0].addEventListener('submit',function( evt ){var file=document.getElementById('file').files[0];<?php echo "if(file&&file.size>".$max_size_file."){evt.preventDefault();}" ?>},false);</script></body></html>