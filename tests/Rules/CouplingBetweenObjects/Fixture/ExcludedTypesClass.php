<?php

namespace Orrison\MeliorStan\Tests\Rules\CouplingBetweenObjects\Fixture;

use Orrison\MeliorStan\Tests\Rules\CouplingBetweenObjects\Fixture\Deps\DepA;
use Orrison\MeliorStan\Tests\Rules\CouplingBetweenObjects\Fixture\Deps\DepB;
use Orrison\MeliorStan\Tests\Rules\CouplingBetweenObjects\Fixture\Deps\DepC;
use Orrison\MeliorStan\Tests\Rules\CouplingBetweenObjects\Fixture\Deps\DepD;

class ExcludedTypesClass
{
    protected DepA $a;

    protected DepB $b;

    public function method(DepC $c): DepD
    {
        return new DepD();
    }
}
