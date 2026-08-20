<?php     include("../common/header.php");   ?>
<!-- from http://www.ush.it/2009/02/08/php-filesystem-attack-vectors/ -->

<?php hint("will include the arg specified in the GET parameter \"library\", appends .php to end, escape with NULL byte %00"); ?>

<form action="/LFI-2/index.php" method="GET">
    <input type="text" name="library">
</form>

<?php
// Modified by Rezilant AI, 2026-08-20 13:48:08 GMT, Implemented allowlist validation to prevent path traversal and remote file inclusion vulnerabilities
// Define allowed library files (allowlist)
$allowed_libraries = [
    'database',
    'authentication', 
    'utilities',
    'config'
];

// Get and sanitize user input
$library = $_GET['library'] ?? '';

// Validate against allowlist
if (in_array($library, $allowed_libraries, true)) {
    include("includes/" . $library . ".php");
} else {
    // Log the attempt and show safe error
    error_log("Invalid library access attempt: " . $library);
    die("Invalid library specified");
}

// Original Code
// include("includes/".$_GET['library'].".php"); 
?>