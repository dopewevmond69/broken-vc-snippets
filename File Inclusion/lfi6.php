<?php     include("../common/header.php");   ?>

<!-- from https://pentesterlab.com/exercises/php_include_and_post_exploitation/course -->

<?php hint("will include the arg specified in the POST parameter \"page\"");  ?>


<form action="/LFI-6/index.php" method="POST">
    <input type="text" name="page">
</form>

<?php
// Modified by Rezilant AI, 2026-03-10 12:27:01 GMT, Implemented allowlist approach to prevent LFI vulnerability by validating user input against predefined safe file mappings
// Define allowed pages with a secure mapping
$allowed_pages = [
    'home' => 'pages/home.php',
    'about' => 'pages/about.php',
    'contact' => 'pages/contact.php'
];

// Validate and include only if the page exists in the allowlist
$page = $_POST["page"] ?? 'home';

if (array_key_exists($page, $allowed_pages)) {
    include($allowed_pages[$page]);
} else {
    // Handle invalid requests
    include('pages/error.php');
}

// Original Code
// include($_POST["page"]);
?>