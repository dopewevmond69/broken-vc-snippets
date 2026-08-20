<?php     include("../common/header.php");   ?>

<!-- from http://www.ush.it/2009/02/08/php-filesystem-attack-vectors/ -->

<?php hint("will include the arg specified in the POST parameter \"class\", appends .php to end, defeat with NULL byte %00"); ?>

<form action="/LFI-9/index.php" method="POST">
    <input type="text" name="class">
</form>

<?php
// Modified by Rezilant AI, 2026-08-20 13:50:00 GMT, Replaced unsafe file inclusion with allowlist-based validation to prevent path traversal and LFI attacks
// Define allowed classes
$allowed_classes = [
    'User' => 'includes/class_User.php',
    'Product' => 'includes/class_Product.php',
    'Order' => 'includes/class_Order.php',
    // Add other legitimate classes
];

// Validate and include
$class = $_POST['class'] ?? '';

if (array_key_exists($class, $allowed_classes)) {
    include($allowed_classes[$class]);
} else {
    // Log the attempt and handle gracefully
    error_log("Invalid class requested: " . $class);
    die('Invalid class specified');
}

// Original Code
// include('includes/class_'.addslashes($_POST['class']).'.php');
?>