<?php
include 'cloudinary_php/src/Cloudinary.php';
include 'cloudinary_php/src/Uploader.php';
if (file_exists('settings.php')) {
  include 'settings.php';
}
$hash= hexdec(substr (hash('md5',basename($_FILES['userfile']['name'])),0,4));
$uploaddir = '/tmp/'.time();
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
$result = \Cloudinary\Uploader::upload($uploadfile,array("width" => 90, "height" => 90, "crop" => "thumb", "gravity" => "face"));
unlink($uploadfile);

$key=$keys[$hash % count($keys)-1];
header("HTTP/1.1 301 Moved Permanently");
header("Location: http://afthon.github.io/apr06/result.html?url=".urlencode($result['url'])."&keyword=".urlencode($key));
