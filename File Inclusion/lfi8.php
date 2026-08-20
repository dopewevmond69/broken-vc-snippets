<?php     include("../common/header.php");   ?>

<!-- from http://www.ush.it/2009/02/08/php-filesystem-attack-vectors/ -->
<?php hint("will include the arg specified in the POST parameter \"file\", looks for .php at end - bypass by apending /. (slash plus dot)"); ?>

<form action="/LFI-8/index.php" method="POST">
    <input type="text" name="file">
</form>


<?php
// Modified by Rezilant AI, 2026-08-20 15:24:53 GMT, Fixed Local File Inclusion (LFI) vulnerability by implementing whitelist-based file access validation and output encoding
// 1. Whitelist allowed files
$allowed_files = [
    'page1' => '/var/www/html/content/page1.txt',
    'page2' => '/var/www/html/content/page2.txt',
    'about' => '/var/www/html/content/about.txt'
];

// 2. Validate input against whitelist
$file_key = $_POST['file'] ?? '';

if (!isset($allowed_files[$file_key])) {
    die('Invalid file request');
}

// 3. Get the validated file path
$file_path = $allowed_files[$file_key];

// 4. Read and encode output
$content = file_get_contents($file_path);
echo htmlspecialchars($content, ENT_QUOTES, 'UTF-8');

// Original Code - Vulnerable to LFI and Path Traversal
// if (substr($_POST['file'], -4, 4) != '.php')
//  echo file_get_contents($_POST['file']);
// else
//  echo 'You are not allowed to see source files!'."\n";
?>