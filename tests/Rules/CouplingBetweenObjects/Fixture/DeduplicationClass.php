<?php

namespace Orrison\MeliorStan\Tests\Rules\CouplingBetweenObjects\Fixture;

use Orrison\MeliorStan\Tests\Rules\CouplingBetweenObjects\Fixture\Deps\DepA;
use Orrison\MeliorStan\Tests\Rules\CouplingBetweenObjects\Fixture\Deps\DepB;

class DeduplicationClass
{
    protected DepA $propA;

    public function method(DepA $a): DepA
    {
        $instance = new DepA();

        if ($instance instanceof DepA) {
            return $instance;
        }

        return new DepB();
    }
}
