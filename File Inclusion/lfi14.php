<!-- from https://github.com/ewilded/psychoPATH -->
<?php     include("../common/header.php");   ?>

<?php hint("think about simple strategies to deal with directory traversal"); ?>

<form action="/LFI-14/index.php" method="POST">
    <input type="text" name="file">
    <input type="hidden" name="style" name="stylepath">
</form>

<?php
   // Modified by Rezilant AI, 2026-03-13 02:11:33 GMT, Replaced vulnerable dynamic include with allowlist-based validation to prevent LFI/RFI attacks
   // Define allowed pages in an allowlist
   $allowed_pages = [
       'home' => 'pages/home.php',
       'about' => 'pages/about.php',
       'contact' => 'pages/contact.php',
       'services' => 'pages/services.php'
   ];

   // Get user input
   $file = isset($_POST['file']) ? $_POST['file'] : 'home';

   // Validate against allowlist and use default if invalid
   if (array_key_exists($file, $allowed_pages)) {
       include($allowed_pages[$file]);
   } else {
       // Default to home page or show error
       include($allowed_pages['home']);
       // Optional: Log suspicious activity
       error_log("Invalid page request attempted: " . $file);
   }

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