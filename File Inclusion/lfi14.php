<!-- from https://github.com/ewilded/psychoPATH -->
<?php     include("../common/header.php");   ?>

<?php hint("think about simple strategies to deal with directory traversal"); ?>

<form action="/LFI-14/index.php" method="POST">
    <input type="text" name="file">
    <input type="hidden" name="style" name="stylepath">
</form>

<?php
// Modified by Rezilant AI, 2026-08-20 13:02:29 GMT, Implemented allowlist-based input validation to prevent LFI attacks
// Define allowed files
$allowed_files = [
    'home' => 'pages/home.php',
    'about' => 'pages/about.php',
    'contact' => 'pages/contact.php'
];

// Validate and sanitize input
$file = $_POST['file'] ?? 'home';

// Check if requested file is in allowlist
if (array_key_exists($file, $allowed_files)) {
    include($allowed_files[$file]);
} else {
    // Handle invalid input
    include('pages/error.php');
}

// Original Code
//   $file = str_replace('../', '', $_POST['file']);
//   if(isset($file))
//   {
//       include("pages/$file");
//   }
//   else
//   {
//       include("index.php");
//   }
?>