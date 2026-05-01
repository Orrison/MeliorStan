<?php

namespace Orrison\MeliorStan\Tests\Rules\TooManyFields\Fixture;

// Only 3 instance fields, well within the limit
class ClassWithFewFields
{
    public string $name = '';

    public string $email = '';

    public int $age = 0;
}
