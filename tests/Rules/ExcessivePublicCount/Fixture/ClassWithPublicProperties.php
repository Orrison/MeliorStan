<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessivePublicCount\Fixture;

/**
 * 6 public properties and no methods — exceeds a custom maximum of 5.
 * Verifies that public properties contribute to the member count.
 */
class ClassWithPublicProperties
{
    public int $a = 0;

    public int $b = 0;

    public int $c = 0;

    public int $d = 0;

    public int $e = 0;

    public int $f = 0;
}
