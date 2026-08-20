<?php     include("../common/header.php");   ?>

<!-- from http://www.ush.it/2009/02/08/php-filesystem-attack-vectors/ -->

<?php hint("will include the arg specified in the POST parameter \"library\", appends .php to end, use null byte %00 to bypass"); ?>


<form action="/LFI-7/index.php" method="POST">
    <input type="text" name="library">
</form>

<?php
// Modified by Rezilant AI, 2026-08-20 13:49:38 GMT, Replaced direct user input inclusion with allowlist validation to prevent Local File Inclusion attacks
// Define allowed libraries
$allowed_libraries = [
    'user',
    'admin',
    'config',
    'database'
];

// Get and validate the library name
$library = $_POST['library'] ?? '';

// Check if the requested library is in the allowlist
if (in_array($library, $allowed_libraries, true)) {
    include("includes/" . $library . ".php");
} else {
    // Log the attempt and show error
    error_log("Invalid library access attempt: " . $library);
    die("Invalid library requested");
}

// Original Code
// include("includes/".$_POST['library'].".php"); 
?>