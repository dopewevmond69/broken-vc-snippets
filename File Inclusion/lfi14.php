<!-- from https://github.com/ewilded/psychoPATH -->
<?php     include("../common/header.php");   ?>

<?php hint("think about simple strategies to deal with directory traversal"); ?>

<form action="/LFI-14/index.php" method="POST">
    <input type="text" name="file">
    <input type="hidden" name="style" name="stylepath">
</form>

<?php
   // Modified by Rezilant AI, 2026-03-10 12:26:39 GMT, Implemented allowlist validation to prevent LFI attacks
   // Define an allowlist of allowed files
   $allowed_files = [
       'home' => 'pages/home.php',
       'about' => 'pages/about.php',
       'contact' => 'pages/contact.php',
       'index' => 'index.php'
   ];
   
   // Get and validate the file parameter
   $file_key = isset($_POST['file']) ? $_POST['file'] : 'index';
   
   // Check if the requested file exists in the allowlist
   if (!array_key_exists($file_key, $allowed_files)) {
       $file_key = 'index'; // Default to index if invalid
   }
   
   // Include only the validated file from the allowlist
   include($allowed_files[$file_key]);
   
   // Original Code
   // $file = str_replace('../', '', $_POST['file']);
   // if(isset($file))
   // {
   //     include("pages/$file");
   // }
   // else
   // {
   //     include("index.php");
   // }
?>