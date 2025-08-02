<?php

namespace Orrison\MessedUpPhpstan\Tests\Rules\ShortMethodName\Fixture;

class ExampleClass
{
    public function a(): void // Error: 1 character
    {}

    public function ab(): void // Error: 2 characters
    {}

    public function abc(): void // Valid: 3 characters
    {}

    public function abcd(): void // Valid: 4+ characters
    {}

    public function x(): void // Error: 1 character
    {}

    public function is(): void // Error: 2 characters
    {}

    public function get(): void // Valid: 3 characters
    {}

    public function getName(): void // Valid: 7 characters
    {}

    public static function z(): void // Error: 1 character
    {}

    public static function xyz(): void // Valid: 3 characters
    {}

    protected function cd(): void // Error: 2 characters
    {}

    protected function efg(): void // Valid: 3 characters
    {}

    private function b(): void // Error: 1 character
    {}
}
