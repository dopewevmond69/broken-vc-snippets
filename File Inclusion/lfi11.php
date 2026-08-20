<!-- from http://hakipedia.com/index.php/Local_File_Inclusion -->
<?php     include("../common/header.php");   ?>

<?php hint("not everything you need to play with is in a text field"); ?>

<form action="/LFI-11/index.php" method="POST">
    <input type="text" name="file">
    <input type="hidden" name="style" name="stylepath">
</form>

<!-- Modified by Rezilant AI, 2026-08-20 13:00:51 GMT, Implemented allowlist validation to prevent arbitrary file inclusion -->
<?php
// Define allowed style files
$allowed_styles = [
    'default' => '/styles/default.css.php',
    'dark' => '/styles/dark.css.php',
    'light' => '/styles/light.css.php'
];

// Get user input
$style_choice = $_POST['stylepath'] ?? 'default';

// Validate against allowlist
if (array_key_exists($style_choice, $allowed_styles)) {
    include($allowed_styles[$style_choice]);
} else {
    // Fallback to default or throw error
    include($allowed_styles['default']);
}
?>

<!-- Original Code -->
<?php //include($_POST['stylepath']); ?>