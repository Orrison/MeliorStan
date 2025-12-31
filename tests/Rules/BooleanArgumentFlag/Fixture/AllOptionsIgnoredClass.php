<?php

namespace Orrison\MeliorStan\Tests\Rules\BooleanArgumentFlag\Fixture;

class AllOptionsIgnoredClass
{
    public function setFlag(bool $flag) {}

    public function process(bool $flag) {}

    public function handle(bool $value) {}
}
