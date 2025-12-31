<?php

namespace Orrison\MeliorStan\Tests\Rules\ConstructorWithNameAsEnclosingClass\Fixture;

interface ExampleInterface
{
    // Valid: interfaces don't have implementations, so this is not flagged
    public function ExampleInterface();
}
