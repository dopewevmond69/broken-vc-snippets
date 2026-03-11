<?php

require_once('../_helpers/strip.php');

// first, get a variable name based on the user input
$variable = strlen($_GET['variable']) > 0 ? $_GET['variable'] : 'empty';
$empty = 'No variable given';

// pass the variable name into an eval block, making it
// vulnerable to Remote Code Execution (rce). This RCE
// is NOT blind.
// Modified by Rezilant AI, 2026-03-11 17:11:14 GMT, Replaced eval() with whitelist validation to prevent Remote Code Execution
// Define allowed variables
$welcome = 'Welcome message';
$status = 'Active';

// Whitelist of allowed variable names
$allowedVariables = ['empty', 'welcome', 'status'];

// Validate against whitelist
if (in_array($variable, $allowedVariables, true)) {
    // Safely access the variable using variable variables (still controlled)
    echo htmlspecialchars($$variable, ENT_QUOTES, 'UTF-8');
} else {
    echo htmlspecialchars($empty, ENT_QUOTES, 'UTF-8');
}
// Original Code
// eval('echo $' . $variable . ';');