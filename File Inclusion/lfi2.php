<?php     include("../common/header.php");   ?>
<!-- from http://www.ush.it/2009/02/08/php-filesystem-attack-vectors/ -->

<?php hint("will include the arg specified in the GET parameter \"library\", appends .php to end, escape with NULL byte %00"); ?>

<form action="/LFI-2/index.php" method="GET">
    <input type="text" name="library">
</form>

<?php
// Modified by Rezilant AI, 2026-03-10 12:27:06 GMT, Implemented allowlist validation to prevent Local File Inclusion attacks
// Define allowed libraries
$allowed_libraries = [
    'functions',
    'database',
    'auth',
    'utils'
];

// Get and validate user input
$library = $_GET['library'] ?? '';

// Check if requested library is in allowlist
if (in_array($library, $allowed_libraries, true)) {
    include("includes/" . $library . ".php");
} else {
    // Handle invalid request
    die("Invalid library requested");
}

// Original Code
// include("includes/".$_GET['library'].".php"); 
?>