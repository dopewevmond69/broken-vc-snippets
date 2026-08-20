<!-- from https://github.com/ewilded/psychoPATH -->
<?php     include("../common/header.php");   ?>

<?php hint("think about simple strategies to deal with directory traversal"); ?>

<form action="/LFI-13/index.php" method="GET">
    <input type="text" name="file">
</form>

<?php
// Modified by Rezilant AI, 2026-08-20 13:01:55 GMT, Implemented strict allowlist validation to prevent path traversal and arbitrary file inclusion
// Define allowed files
$allowedFiles = [
    'home' => 'pages/home.php',
    'about' => 'pages/about.php',
    'contact' => 'pages/contact.php',
    'services' => 'pages/services.php'
];

// Get user input
$file = $_GET['file'] ?? 'home';

// Validate against allowlist
if (array_key_exists($file, $allowedFiles)) {
    include($allowedFiles[$file]);
} else {
    // Handle invalid input - redirect to default page
    include($allowedFiles['home']);
    // Or show error: http_response_code(404);
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