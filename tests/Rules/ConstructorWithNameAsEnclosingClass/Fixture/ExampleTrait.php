<?php

namespace Orrison\MeliorStan\Tests\Rules\ConstructorWithNameAsEnclosingClass\Fixture;

trait ExampleTrait
{
    // Valid: traits don't have constructors, so this is not flagged
    public function ExampleTrait() {}
}
