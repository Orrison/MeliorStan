<?php

function testFunction()
{
    for ($i = 0; $i < 10; $i++) {
        // Loop body
    }

    $i = 'after for loop';

    $items = [1, 2, 3];

    foreach ($items as $k => $v) {
        // Loop body
    }

    $k = 'after foreach';
    $v = 'after foreach';
}

function anotherFunction()
{
    try {
        throw new Exception('test');
    } catch (Exception $e) {
        // Catch body
    }

    $e = 'after catch';
}

$x = 'short';
$j = 'also short';
