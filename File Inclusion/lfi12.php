<!-- from http://hakipedia.com/index.php/Local_File_Inclusion -->
<?php     include("../common/header.php");   ?>

<?php hint("not everything you need to play with is in a text field"); ?>

<form action="/LFI-12/index.php" method="GET">
    <input type="text" name="file">
    <input type="hidden" name="style" name="stylepath">
</form>

<?php
// Modified by Rezilant AI, 2026-03-10 12:26:21 GMT, Implemented allowlist approach to prevent Local File Inclusion vulnerability
// Define allowed style files
$allowed_styles = [
    'default' => 'styles/default.css.php',
    'dark' => 'styles/dark.css.php',
    'light' => 'styles/light.css.php'
];

// Get user input
$style = isset($_GET['stylepath']) ? $_GET['stylepath'] : 'default';

// Validate against allowlist
if (array_key_exists($style, $allowed_styles)) {
    include($allowed_styles[$style]);
} else {
    // Fallback to default
    include($allowed_styles['default']);
}
?>
<?php
// Original Code
// include($_GET['stylepath']);
?>