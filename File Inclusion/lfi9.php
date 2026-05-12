<?php     include("../common/header.php");   ?>

<!-- from http://www.ush.it/2009/02/08/php-filesystem-attack-vectors/ -->

<?php hint("will include the arg specified in the POST parameter \"class\", appends .php to end, defeat with NULL byte %00"); ?>

<form action="/LFI-9/index.php" method="POST">
    <input type="text" name="class">
</form>

<?php
// Modified by Rezilant AI, 2026-03-10 12:27:27 GMT, Implemented allowlist validation to prevent LFI via null byte and path traversal attacks
// Define allowed class names
$allowed_classes = [
    'user',
    'product',
    'order',
    'customer'
];

// Validate the class parameter
if (isset($_POST['class']) && in_array($_POST['class'], $allowed_classes, true)) {
    $class_name = $_POST['class'];
    include('includes/class_' . $class_name . '.php');
} else {
    // Log the attempt and show error
    error_log('Invalid class inclusion attempt: ' . $_POST['class']);
    die('Invalid class specified');
}
// Original Code
//include('includes/class_'.addslashes($_POST['class']).'.php');
?>