<!-- from https://github.com/ewilded/psychoPATH -->
<?php     include("../common/header.php");   ?>

<?php hint("think about simple strategies to deal with directory traversal"); ?>

<form action="/LFI-13/index.php" method="GET">
    <input type="text" name="file">
</form>

<?php
// Modified by Rezilant AI, 2026-03-13 02:11:39 GMT, Implemented strict allowlist-based approach to prevent LFI by mapping user input to predefined safe files
// Define allowlist of permitted files
$allowedFiles = [
    'home' => 'pages/home.php',
    'about' => 'pages/about.php',
    'contact' => 'pages/contact.php',
    'services' => 'pages/services.php'
];

// Get user input
$file = isset($_GET['file']) ? $_GET['file'] : 'home';

// Validate against allowlist
if (array_key_exists($file, $allowedFiles)) {
    include($allowedFiles[$file]);
} else {
    // Default to safe page or show error
    include('pages/home.php');
    // Or: echo "Page not found";
}

// Original Code
//    $file = str_replace('../', '', $_GET['file']);
//    if(isset($file))
//    {
//        include("pages/$file");
//    }
//    else
//    {
//        include("index.php");
//    }
?>