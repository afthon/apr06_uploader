<?php
include 'cloudinary_php/src/Cloudinary.php';
include 'cloudinary_php/src/Uploader.php';
if (file_exists('settings.php')) {
  include 'settings.php';
}
$uploaddir = '/tmp/'.time();
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
$hash= 0;
move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
$handle = @fopen($uploadfile, "r");
if ($handle) {
    while (!feof($handle)) {
        $hash = hexdec(bin2hex(fread ($handle , 4 )));
    }
    fclose($handle);

}
$result = \Cloudinary\Uploader::upload($uploadfile,array("width" => 90, "height" => 90, "crop" => "thumb", "gravity" => "face"));
unlink($uploadfile);

$index=$hash % count($keys);
$key=$keys[$index < 0 ? 0 : $index];
header("HTTP/1.1 301 Moved Permanently");
header("Location: http://afthon.github.io/apr06/result.html?url=".urlencode($result['url'])."&keyword=".urlencode($key));
