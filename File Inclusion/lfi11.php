<!-- from http://hakipedia.com/index.php/Local_File_Inclusion -->
<?php     include("../common/header.php");   ?>

<?php hint("not everything you need to play with is in a text field"); ?>

<form action="/LFI-11/index.php" method="POST">
    <input type="text" name="file">
    <input type="hidden" name="style" name="stylepath">
</form>

<?php
// Modified by Rezilant AI, 2026-03-10 12:26:10 GMT, Implemented strict allowlist validation to prevent LFI attacks
// Define allowed style files
$allowed_styles = [
    'default' => 'styles/default.css',
    'dark' => 'styles/dark.css',
    'light' => 'styles/light.css'
];

// Get and validate user input
$style_choice = $_POST['stylepath'] ?? 'default';

// Only include if it exists in allowlist
if (array_key_exists($style_choice, $allowed_styles)) {
    $safe_path = $allowed_styles[$style_choice];
    include($safe_path);
} else {
    // Default fallback
    include($allowed_styles['default']);
}
?>

<?php
// Original Code
// include($_POST['stylepath']);
?>