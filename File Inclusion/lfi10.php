<!-- from http://hakipedia.com/index.php/Local_File_Inclusion -->
<?php     include("../common/header.php");   ?>

<?php hint("will include the arg specified in the POST parameter \"file\", strips prepended \"../\" strings, must encode / with %2f"); ?>

<form action="/LFI-10/index.php" method="POST">
    <input type="text" name="file">
</form>

<?php
   // Modified by Rezilant AI, 2026-03-10 12:26:04 GMT, Implement file allowlisting to prevent Local File Inclusion vulnerability
   // Define allowed files
   $allowed_files = [
       'home' => 'pages/home.php',
       'about' => 'pages/about.php',
       'contact' => 'pages/contact.php',
       'services' => 'pages/services.php'
   ];

   // Get user input
   $file = $_POST['file'] ?? 'home';

   // Validate against whitelist
   if (array_key_exists($file, $allowed_files)) {
       include($allowed_files[$file]);
   } else {
       // Handle invalid input
       include('pages/error.php');
       // Or: http_response_code(404);
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