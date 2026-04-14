<?php

namespace Orrison\MeliorStan\Tests\Rules\CouplingBetweenObjects\Fixture;

use Orrison\MeliorStan\Tests\Rules\CouplingBetweenObjects\Fixture\Deps\AnotherAttribute;
use Orrison\MeliorStan\Tests\Rules\CouplingBetweenObjects\Fixture\Deps\DepA;
use Orrison\MeliorStan\Tests\Rules\CouplingBetweenObjects\Fixture\Deps\DepB;
use Orrison\MeliorStan\Tests\Rules\CouplingBetweenObjects\Fixture\Deps\DepC;
use Orrison\MeliorStan\Tests\Rules\CouplingBetweenObjects\Fixture\Deps\SomeAttribute;

#[SomeAttribute]
class AttributeCouplingClass
{
    #[AnotherAttribute]
    protected DepA $a;

    public function method(DepB $b): DepC
    {
        return new DepC();
    }
}
