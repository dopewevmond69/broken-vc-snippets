<?php

$UploadDir = '/var/www/';

if (!(isset($_GET['file'])))
  die();


$file = $_GET['file'];

$path = $UploadDir . $file;

if (!is_file($path))
  die();

header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Cache-Control: public');
header('Content-Disposition: inline; filename="' . basename($path) . '";');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($path));

$handle = fopen($path, 'rb');

do {
$data = fread($handle, 8192);
if (strlen($data) == 0) {
break;
}
// Modified by Rezilant AI, 2026-08-20 15:25:36 GMT, Applied output encoding to prevent XSS by sanitizing user data with htmlspecialchars
echo htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
// Original Code
// echo($data);
} while (true);

fclose($handle);
exit();
?>