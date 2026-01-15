?php

require_once../_helpers/strip.php

// first, get a variable name based on the user input
variable = strlen_GETvariable  0 ? _GETvariable : empty
empty = No variable given

// pass the variable name into an eval block, making it
// vulnerable to Remote Code Execution rce. This RCE
// is NOT blind.
// Modified by Rezilant AI, 2026-01-15 12:00:21 GMT, Replace eval with whitelist-based variable access to prevent RCE
// Define allowed variables in a whitelist
all