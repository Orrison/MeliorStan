<?php

namespace Orrison\MeliorStan\Tests\Rules\CouplingBetweenObjects\Fixture;

use Orrison\MeliorStan\Tests\Rules\CouplingBetweenObjects\Fixture\Deps\DepA;
use Orrison\MeliorStan\Tests\Rules\CouplingBetweenObjects\Fixture\Deps\DepB;
use Orrison\MeliorStan\Tests\Rules\CouplingBetweenObjects\Fixture\Deps\DepC;
use Orrison\MeliorStan\Tests\Rules\CouplingBetweenObjects\Fixture\Deps\DepD;
use Orrison\MeliorStan\Tests\Rules\CouplingBetweenObjects\Fixture\Deps\Excluded\ExcludedDepA;
use Orrison\MeliorStan\Tests\Rules\CouplingBetweenObjects\Fixture\Deps\Excluded\ExcludedDepB;

class ExcludedNamespacesClass
{
    protected DepA $a;

    protected ExcludedDepA $excludedA;

    protected ExcludedDepB $excludedB;

    public function method(DepB $b): DepC
    {
        return new DepC();
    }

    public function anotherMethod(DepD $d): void {}
}
