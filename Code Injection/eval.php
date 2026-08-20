<?php

require_once('../_helpers/strip.php');

// first, get a variable name based on the user input
$variable = strlen($_GET['variable']) > 0 ? $_GET['variable'] : 'empty';
$empty = 'No variable given';

// pass the variable name into an eval block, making it
// vulnerable to Remote Code Execution (rce). This RCE
// is NOT blind.
// Modified by Rezilant AI, 2026-08-20 12:55:19 GMT, Replaced dangerous eval() with variable variables to prevent Remote Code Execution
if (isset($$variable)) {
    echo htmlspecialchars($$variable, ENT_QUOTES, 'UTF-8');
}
// Original Code
// eval('echo $' . $variable . ';');