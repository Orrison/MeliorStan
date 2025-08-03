<?php

class ExampleClass
{
    public function methodWithClosures()
    {
        // Valid - closure with typed parameters
        $validClosure = function (string $name, int $age): string {
            return $name . ' is ' . $age . ' years old';
        };

        // Invalid - closure with untyped parameters
        $invalidClosure1 = function ($name, $age) {
            return $name . ' is ' . $age . ' years old';
        };

        // Mixed - some typed, some untyped
        $mixedClosure = function (string $name, $age, int $id) {
            return $name . ' with ID ' . $id . ' is ' . $age . ' years old';
        };

        // Valid - closure with no parameters
        $noParamsClosure = function (): string {
            return 'No parameters';
        };

        // Invalid - multiple untyped parameters
        $multipleUntyped = function ($first, $second, $third) {
            return $first . $second . $third;
        };

        // Valid - using in array_map with typed parameter
        $numbers = [1, 2, 3];
        array_map(function (int $n): int {
            return $n * 2;
        }, $numbers);

        // Invalid - array_map with untyped parameter
        array_map(function ($n) {
            return $n * 2;
        }, $numbers);

        // Valid - closure with reference parameter that has type
        $refClosure = function (string &$value): void {
            $value = strtoupper($value);
        };

        // Invalid - closure with reference parameter without type
        $refUntypedClosure = function (&$value) {
            $value = strtoupper($value);
        };
    }
}
