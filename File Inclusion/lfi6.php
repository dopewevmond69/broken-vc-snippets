<?php     include("../common/header.php");   ?>

<!-- from https://pentesterlab.com/exercises/php_include_and_post_exploitation/course -->

<?php hint("will include the arg specified in the POST parameter \"page\"");  ?>


<form action="/LFI-6/index.php" method="POST">
    <input type="text" name="page">
</form>

<?php
// Modified by Rezilant AI, 2026-08-20 13:49:14 GMT, Replaced direct file inclusion with allowlist validation to prevent Local File Inclusion (LFI) vulnerability
// Define allowlist of permitted files
$allowed_pages = [
    'home' => 'pages/home.php',
    'about' => 'pages/about.php',
    'contact' => 'pages/contact.php'
];

// Validate and sanitize input
$requested_page = $_POST["page"] ?? 'home';

// Check if requested page exists in allowlist
if (array_key_exists($requested_page, $allowed_pages)) {
    include($allowed_pages[$requested_page]);
} else {
    // Handle invalid request safely
    include('pages/404.php');
}

// Original Code
// include($_POST["page"]);
?>