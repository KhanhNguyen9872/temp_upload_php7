<?php
// Hostname website
$hostname="https://temp.run.goorm.io";
// Maximum upload file size (byte)
$max_size_file=1073741824;
// Folder save file upload
$upload_folder="uploads";
// Folder for user download
$download_folder="file";
// Date of folder
$date=date("Y-m-d");
// keep file upload
// 0 for Disable keep file
// 1 for Keep file from [upload_folder], but link download will be removed
// 2 for Keep file from [upload_folder] and keep link download
$keep_file_upload=0;
// get log from upload and download (0 for FALSE, 1 for TRUE)
$islog=1;
// Folder for save log
$log_folder="log";
// Check Windows or not
if(strtoupper(substr(PHP_OS, 0, 3))==='WIN'){
	$win="1";
	$null_out=" > NUL 2>&1";
	$null_2=" 2> NUL";
	$rm_folder="rmdir /q /s ";
	$mkdir="mkdir ";
	$mk_symlink="mklink /d ";
	$sym="\\";
	$sym1="/";
}else{
	$win="0";
	$null_out=" > /dev/null 2>&1";
	$null_2=" 2> /dev/null";
	$rm_folder="rm -rf ";
	$mkdir="mkdir ";
	$mk_symlink="ln -s ";
	$sym="/";
	$sym1="\\";
};
// Get IP Public from user
$ip=$_SERVER['REMOTE_ADDR'];
$get_type=$_SERVER['REQUEST_METHOD'];
if(($get_type=="GET") || ($get_type=="POST")){$khanh=$_SERVER['REQUEST_URI'];
  if(($khanh=="/config.php")||(strpos($khanh,"/index.php")!==false)||(strpos($khanh,"/".$upload_folder."/")!==false)){require '404.php';die();};
  if(phpversion() < 7.0){die("PHP Version too old (".phpversion().")");};
  if(ini_get('file_uploads')!="1"){die("File upload has been disabled on the server!");};}else{require '405.php';die();
};
unset($get_type,$khanh);
function check_sw(){
	$check=$_SERVER['HTTP_USER_AGENT'];
	if((strpos($check,"curl")!==false)||(strpos($check,"aria2")!==false)||(strpos($check,"Wget")!==false)||(strpos($check,"PowerShell")!==false)){return 1;};
	return 0;
};
function random_string($a=20){
  $characters='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength=strlen($characters);
  $randomString='';
  for ($i=0; $i < $a; $i++){$randomString.=$characters[rand(0, $charactersLength - 1)];};
  return $randomString;
};
function write_log($z,$islog,$log_folder,$mkdir,$null_out,$sym,$ip,$type,$file_name2,$size_file,$random,$file_type){
	if($islog==1){
		if(!is_dir($z.$sym.$log_folder)){exec($mkdir.$z.$sym. $log_folder.$null_out);};
		if(!is_file($z.$sym.$log_folder.$sym.".htaccess")){exec("echo Deny from all > ".$z.$sym.$log_folder.$sym.".htaccess".$null_2);};
		$sd=fopen($z.$sym.$log_folder.$sym.date('d-m-Y', time()).".log", "a");
		fwrite($sd, "[".date('d/m/Y h:i:s a', time())."] (".$ip.") ".$type.": {\"".$file_name2."\", \"".$size_file." byte\", \"".$random."\", \"".$file_type."\"}\n");
		fclose($sd);
  };
};
$z=str_replace($sym1,$sym,$_SERVER['DOCUMENT_ROOT']);
$target_dir=$upload_folder.$sym.$date.$sym;
if(!is_dir($z.$sym.$target_dir)){
  if(($keep_file_upload==0)||($keep_file_upload==1)){exec($rm_folder.$z.$sym.$download_folder.$null_out);};
  if($keep_file_upload==0){exec($rm_folder.$z.$sym.$upload_folder.$null_out);};
  exec($mkdir.$z.$sym.$download_folder.$null_out);
  exec($mkdir.$z.$sym.$upload_folder.$null_out);
  exec($mkdir.$z.$sym.$target_dir.$null_out);
  header("refresh: 0");
};
if(!is_file($z.$sym.$upload_folder.$sym.".htaccess")){exec("echo Deny from all > ".$z.$sym.$upload_folder.$sym.".htaccess".$null_2);};
if(!is_dir($z.$sym.$download_folder)){exec($mkdir.$z.$sym.$download_folder.$null_out);};
?>