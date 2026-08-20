<!-- from http://hakipedia.com/index.php/Local_File_Inclusion -->
<?php     include("../common/header.php");   ?>

<?php hint("will include the arg specified in the GET parameter \"file\", strips prepended \"../\" strings, must encode / with %2f"); ?>


<form action="/LFI-5/index.php" method="GET">
    <input type="text" name="file">
</form>

<?php
   // Modified by Rezilant AI, 2026-08-20 13:48:52 GMT, Implemented allowlist to prevent Local File Inclusion vulnerability
   // Define allowed pages in an allowlist
   $allowed_pages = [
       'home' => 'pages/home.php',
       'about' => 'pages/about.php',
       'contact' => 'pages/contact.php',
       'products' => 'pages/products.php'
   ];

   // Get user input
   $page = $_GET['file'] ?? 'home';

   // Check if the requested page exists in allowlist
   if (array_key_exists($page, $allowed_pages)) {
       include($allowed_pages[$page]);
   } else {
       // Default to safe page or show error
       include('pages/home.php');
   }

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