<?php

// Pure procedural file - no classes, functions, namespaces, etc.

$i = 'before for loop'; // Should be violation

for ($i = 0; $i < 10; $i++) {
    // Loop body - $i should be exempt if allowed
}

$i = 'after for loop'; // Should be violation

$x = 'short var'; // Should be violation
