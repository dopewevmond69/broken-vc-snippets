<?php     include("../common/header.php");   ?>

<!-- from http://www.ush.it/2009/02/08/php-filesystem-attack-vectors/ -->
<?php hint("will include the arg specified in the GET parameter \"class\", appends .php to end, defeat with NULL byte %00"); ?>


<form action="/LFI-4/index.php" method="GET">
    <input type="text" name="class">
</form>

<?php
// Modified by Rezilant AI, 2026-08-20 13:48:29 GMT, Replaced dynamic include with strict allowlist validation to prevent LFI/path traversal attacks
// Define allowed classes
$allowed_classes = [
    'user' => 'includes/class_user.php',
    'admin' => 'includes/class_admin.php',
    'product' => 'includes/class_product.php'
    // Add other legitimate classes here
];

// Validate and include
$class = $_GET['class'] ?? '';

if (array_key_exists($class, $allowed_classes)) {
    include($allowed_classes[$class]);
} else {
    // Handle invalid input
    die('Invalid class requested');
}

// Original Code
// include('includes/class_'.addslashes($_GET['class']).'.php');
?>