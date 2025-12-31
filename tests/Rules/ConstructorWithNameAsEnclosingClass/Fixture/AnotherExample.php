<?php

namespace Orrison\MeliorStan\Tests\Rules\ConstructorWithNameAsEnclosingClass\Fixture;

class AnotherExample
{
    // Invalid: method with same name as this class
    public function AnotherExample() {}
}
