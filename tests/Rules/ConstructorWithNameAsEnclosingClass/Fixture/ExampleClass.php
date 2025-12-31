<?php

namespace Orrison\MeliorStan\Tests\Rules\ConstructorWithNameAsEnclosingClass\Fixture;

class ExampleClass
{
    // Valid: __construct is the actual constructor
    public function __construct() {}

    // Valid: method with different name
    public function doSomething() {}

    // Invalid: method with same name as class (PHP4-style constructor)
    public function ExampleClass() {}

    // Valid: method in different class
    public function someOtherMethod() {}
}
