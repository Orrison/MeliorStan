<?php

namespace Orrison\MeliorStan\Tests\Rules\BooleanArgumentFlag\Fixture;

class AllOptionsNotIgnored
{
    public function setOption(bool $value) {}

    public function handle(bool $flag) {}

    public function processData(bool $flag) {}
}
