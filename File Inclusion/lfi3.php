<?php     include("../common/header.php");   ?>

<!-- from http://www.ush.it/2009/02/08/php-filesystem-attack-vectors/ -->
<?php hint("will include the arg specified in the GET parameter \"file\", looks for .php at end - bypass by apending /. (slash plus dot)"); ?>


<form action="/LFI-3/index.php" method="GET">
    <input type="text" name="file">
</form>


<?php
// Modified by Rezilant AI, 2026-08-20 15:24:26 GMT, Fixed Local File Inclusion and XSS vulnerabilities by implementing whitelist validation and output encoding
// Define allowed files with a whitelist
$allowed_files = [
    'about' => '/var/www/html/pages/about.txt',
    'contact' => '/var/www/html/pages/contact.txt',
    'terms' => '/var/www/html/pages/terms.txt'
];

// Validate input against whitelist
$file_key = $_GET['file'] ?? '';

if (array_key_exists($file_key, $allowed_files)) {
    $file_path = $allowed_files[$file_key];
    
    // Verify file exists and is readable
    if (file_exists($file_path) && is_readable($file_path)) {
        $content = file_get_contents($file_path);
        // Sanitize output to prevent XSS
        echo htmlspecialchars($content, ENT_QUOTES, 'UTF-8');
    } else {
        echo "File not available.";
    }
} else {
    echo "Invalid file request.";
}

// Original Code
// if (substr($_GET['file'], -4, 4) != '.php')
//  echo file_get_contents($_GET['file']);
// else
//  echo 'You are not allowed to see source files!'."\n";
?>