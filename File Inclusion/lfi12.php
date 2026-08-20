<!-- from http://hakipedia.com/index.php/Local_File_Inclusion -->
<?php     include("../common/header.php");   ?>

<?php hint("not everything you need to play with is in a text field"); ?>

<form action="/LFI-12/index.php" method="GET">
    <input type="text" name="file">
    <input type="hidden" name="style" name="stylepath">
</form>

<?php
// Modified by Rezilant AI, 2026-08-20 13:01:24 GMT, Replaced direct user input inclusion with strict allowlist approach to prevent Local File Inclusion vulnerability
// Define allowed style files
$allowedStyles = [
    'default' => 'styles/default.css.php',
    'dark' => 'styles/dark.css.php',
    'light' => 'styles/light.css.php'
];

// Get and validate user input
$styleChoice = $_GET['stylepath'] ?? 'default';

// Check if the requested style exists in the allowlist
if (array_key_exists($styleChoice, $allowedStyles)) {
    include($allowedStyles[$styleChoice]);
} else {
    // Fallback to default
    include($allowedStyles['default']);
}
?>

<?php
// Original Code
// include($_GET['stylepath']);
?>