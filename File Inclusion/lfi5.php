<!-- from http://hakipedia.com/index.php/Local_File_Inclusion -->
<?php     include("../common/header.php");   ?>

<?php hint("will include the arg specified in the GET parameter \"file\", strips prepended \"../\" strings, must encode / with %2f"); ?>


<form action="/LFI-5/index.php" method="GET">
    <input type="text" name="file">
</form>

<?php
// Modified by Rezilant AI, 2026-03-10 12:27:21 GMT, Implemented allowlist approach to prevent Local File Inclusion vulnerability
// Define allowed files in an allowlist
$allowed_files = [
    'index' => 'pages/index.php',
    'about' => 'pages/about.php',
    'contact' => 'pages/contact.php',
    'home' => 'pages/home.php'
];

$file = isset($_GET['file']) ? $_GET['file'] : 'index';

// Validate against allowlist
if (!array_key_exists($file, $allowed_files)) {
    $file = 'index'; // Default to safe value
}

if(isset($file))
{
    include($allowed_files[$file]); // Use mapped path, not user input
}
else
{
    include("index.php");
}

// Original Code
//   $file = str_replace('../', '', $_GET['file']);
//   if(isset($file))
//   {
//       include("pages/$file");
//   }
//   else
//   {
//       include("index.php");
//   }
?>