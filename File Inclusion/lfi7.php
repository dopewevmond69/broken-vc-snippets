<?php     include("../common/header.php");   ?>

<!-- from http://www.ush.it/2009/02/08/php-filesystem-attack-vectors/ -->

<?php hint("will include the arg specified in the POST parameter \"library\", appends .php to end, use null byte %00 to bypass"); ?>


<form action="/LFI-7/index.php" method="POST">
    <input type="text" name="library">
</form>

<?php
// Modified by Rezilant AI, 2026-03-10 12:26:55 GMT, Added allowlist validation to prevent LFI attacks via path traversal and null byte injection
// Define allowed libraries
$allowed_libraries = [
    'config',
    'database',
    'utils',
    'helpers'
];

// Validate and sanitize input
$library = isset($_POST['library']) ? $_POST['library'] : '';

// Check if the requested library is in the allowlist
if (in_array($library, $allowed_libraries, true)) {
    include("includes/" . $library . ".php");
} else {
    // Log the attempt and show generic error
    error_log("Unauthorized library access attempt: " . $library);
    die("Invalid library requested.");
}

// Original Code
//include("includes/".$_POST['library'].".php"); 
?>