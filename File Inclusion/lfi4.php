<?php     include("../common/header.php");   ?>

<!-- from http://www.ush.it/2009/02/08/php-filesystem-attack-vectors/ -->
<?php hint("will include the arg specified in the GET parameter \"class\", appends .php to end, defeat with NULL byte %00"); ?>


<form action="/LFI-4/index.php" method="GET">
    <input type="text" name="class">
</form>

<?php
// Modified by Rezilant AI, 2026-03-10 12:27:10 GMT, Replaced dynamic include with whitelist validation to prevent LFI attacks and null byte injection
// Define allowed classes
$allowed_classes = [
    'user',
    'product',
    'order',
    'category'
];

// Validate input against allowlist
$class = $_GET['class'] ?? '';

if (in_array($class, $allowed_classes, true)) {
    $file_path = 'includes/class_' . $class . '.php';
    if (file_exists($file_path)) {
        include($file_path);
    } else {
        error_log("Missing class file: $file_path");
        die('Class file not found');
    }
} else {
    // Handle invalid input
    die('Invalid class specified');
}

// Original Code
// include('includes/class_'.addslashes($_GET['class']).'.php');
?>