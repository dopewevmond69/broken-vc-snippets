<!-- from https://github.com/ewilded/psychoPATH -->
<?php     include("../common/header.php");   ?>

<?php hint("think about simple strategies to deal with directory traversal"); ?>

<form action="/LFI-13/index.php" method="GET">
    <input type="text" name="file">
</form>

<?php
   // Modified by Rezilant AI, 2026-03-10 12:26:33 GMT, Replaced vulnerable dynamic include with strict allowlist approach to prevent path traversal and arbitrary file inclusion
   // Define allowed files (allowlist)
   $allowed_files = [
       'index' => 'index.php',
       'home' => 'pages/home.php',
       'about' => 'pages/about.php',
       'contact' => 'pages/contact.php'
   ];
   
   // Get and validate the file parameter
   $file = isset($_GET['file']) ? $_GET['file'] : 'index';
   
   // Check if the requested file exists in the allowlist
   if (!array_key_exists($file, $allowed_files)) {
       // Default to index if invalid
       $file = 'index';
   }
   
   // Include only the validated file from the allowlist
   include($allowed_files[$file]);
   
   // Original Code
   // $file = str_replace('../', '', $_GET['file']);
   // if(isset($file))
   // {
   //     include("pages/$file");
   // }
   // else
   // {
   //     include("index.php");
   // }
?>