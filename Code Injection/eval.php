<?php

require_once('../_helpers/strip.php');

// first, get a variable name based on the user input
$variable = strlen($_GET['variable']) > 0 ? $_GET['variable'] : 'empty';
$empty = 'No variable given';

// Modified by Rezilant AI, 2026-04-20 11:35:33 GMT, Replaced eval() with whitelist approach to prevent Remote Code Execution
// Option 1: Use a whitelist of allowed variables
$allowedVariables = ['empty'];

if (in_array($variable, $allowedVariables, true)) {
    echo $$variable; // Variable variables - safer when input is validated
} else {
    echo "Invalid variable requested";
}

// Original Code
// pass the variable name into an eval block, making it
// vulnerable to Remote Code Execution (rce). This RCE
// is NOT blind.
// eval('echo $' . $variable . ';');