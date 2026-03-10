<?php     include("../common/header.php");   ?>

<!-- from https://pentesterlab.com/exercises/php_include_and_post_exploitation/course -->
<?php hint("will include the arg specified in the GET parameter \"page\""); ?>

<form action="/LFI-1/index.php" method="GET">
    <input type="text" name="page">
</form>

<?php
// Modified by Rezilant AI, 2026-03-10 12:24:48 GMT, Implemented whitelist approach to prevent Local File Inclusion vulnerability
// Define allowed pages
$allowed_pages = [
    'home' => 'pages/home.php',
    'about' => 'pages/about.php',
    'contact' => 'pages/contact.php'
];

// Get user input
$page = $_GET["page"] ?? 'home';

// Validate against whitelist
if (array_key_exists($page, $allowed_pages)) {
    include($allowed_pages[$page]);
} else {
    // Handle invalid input
    include('pages/error.php');
}

// Original Code
// include($_GET["page"]);
?>