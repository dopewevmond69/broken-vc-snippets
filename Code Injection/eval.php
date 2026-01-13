<?php

require_once('../_helpers/strip.php');

// first, get a variable name based on the user input
$variable = strlen($_GET['variable']) > 0 ? $_GET['variable'] : 'empty';
$empty = 'No variable given';

// pass the variable name into an eval block, making it
// vulnerable to Remote Code Execution (rce). This RCE
// is NOT blind.
// Modified by Rezilant AI, 2025-12-03 18:06:22 GMT, Replaced eval() with whitelist approach to prevent RCE
// Define a whitelist of allowed variables
$allowedVariables = [
    'empty' => 'No variable given',
    'username' => 'John Doe',
    'status' => 'Active'
    // Add other allowed variables here
];

// Get the variable name from user input
$variable = isset($_GET['variable']) && strlen($_GET['variable']) > 0 
    ? $_GET['variable'] 
    : 'empty';

// Safely retrieve the value using the whitelist
if (array_key_exists($variable, $allowedVariables)) {
    echo htmlspecialchars($allowedVariables[$variable], ENT_QUOTES, 'UTF-8');
} else {
    echo htmlspecialchars('Invalid variable requested', ENT_QUOTES, 'UTF-8');
}
// Original Code
// eval('echo $' . $variable . ';');