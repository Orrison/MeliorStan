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

class AnotherExample
{
    // Invalid: method with same name as this class
    public function AnotherExample() {}
}

trait ExampleTrait
{
    // Valid: traits don't have constructors, so this is not flagged
    public function ExampleTrait() {}
}

interface ExampleInterface
{
    // Valid: interfaces don't have implementations, so this is not flagged
    public function ExampleInterface();
}
