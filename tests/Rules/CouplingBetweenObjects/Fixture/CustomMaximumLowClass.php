<?php

namespace Orrison\MeliorStan\Tests\Rules\CouplingBetweenObjects\Fixture;

use Orrison\MeliorStan\Tests\Rules\CouplingBetweenObjects\Fixture\Deps\DepA;
use Orrison\MeliorStan\Tests\Rules\CouplingBetweenObjects\Fixture\Deps\DepB;
use Orrison\MeliorStan\Tests\Rules\CouplingBetweenObjects\Fixture\Deps\DepC;

class CustomMaximumLowClass
{
    protected DepA $a;

    public function method(DepB $b): DepC
    {
        return new DepC();
    }
}
