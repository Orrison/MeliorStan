<?php

// Non-class file with procedural code and functions

function testFunction() {
    // For loop with short variable
    for ($i = 0; $i < 10; $i++) {
        // Loop body
    }
    
    // Variable after for loop - should be violation
    $i = 'after for loop';
    
    // Foreach with short variables
    $items = [1, 2, 3];
    foreach ($items as $k => $v) {
        // Loop body
    }
    
    // Variables after foreach - should be violations
    $k = 'after foreach';
    $v = 'after foreach';
}

function anotherFunction() {
    try {
        throw new Exception('test');
    } catch (Exception $e) {
        // Catch body
    }
    
    // Variable after catch - should be violation
    $e = 'after catch';
}

// Global scope variables
$x = 'short'; // Should be violation
$j = 'also short'; // Should be violation
