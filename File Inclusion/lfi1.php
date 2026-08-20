<?php     include("../common/header.php");   ?>

<!-- from https://pentesterlab.com/exercises/php_include_and_post_exploitation/course -->
<?php hint("will include the arg specified in the GET parameter \"page\""); ?>

<form action="/LFI-1/index.php" method="GET">
    <input type="text" name="page">
</form>

<?php
// Modified by Rezilant AI, 2026-08-20 12:59:45 GMT, Implemented allowlist approach to prevent LFI/RFI attacks by removing direct user control over file paths
// Define allowed pages
$allowed_pages = [
    'home' => 'pages/home.php',
    'about' => 'pages/about.php',
    'contact' => 'pages/contact.php',
    'profile' => 'pages/profile.php'
];

// Get user input
$page = $_GET["page"] ?? 'home';

// Validate against allowlist
if (array_key_exists($page, $allowed_pages)) {
    include($allowed_pages[$page]);
} else {
    // Handle invalid input - redirect to default page
    include($allowed_pages['home']);
    // Or show an error
    // http_response_code(404);
    // echo "Page not found";
}

// Original Code
// include($_GET["page"]);
?>