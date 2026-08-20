<!-- from http://hakipedia.com/index.php/Local_File_Inclusion -->
<?php     include("../common/header.php");   ?>

<?php hint("will include the arg specified in the POST parameter \"file\", strips prepended \"../\" strings, must encode / with %2f"); ?>

<form action="/LFI-10/index.php" method="POST">
    <input type="text" name="file">
</form>

<?php
   // Modified by Rezilant AI, 2026-08-20 13:00:19 GMT, Replaced direct file inclusion with allowlist approach to prevent path traversal and LFI attacks
   // Define allowed files - strict allowlist of permitted pages
   $allowed_files = [
       'home' => 'pages/home.php',
       'about' => 'pages/about.php',
       'contact' => 'pages/contact.php'
   ];

   // Validate and include - user input only used as lookup key
   if (isset($_POST['file']) && array_key_exists($_POST['file'], $allowed_files)) {
       include($allowed_files[$_POST['file']]);
   } else {
       // Default fallback page
       include("pages/home.php");
   }

   // Original Code - vulnerable to LFI via path traversal
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