<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessiveClassComplexity\Fixture;

$simpleObj = new class () {
    public function getName(): string
    {
        return 'name';
    }
};
