<?php

namespace Orrison\MeliorStan\Tests\Rules\UnusedFormalParameter\Fixture;

class ByReference
{
    public function fill(int &$out): void {}
}
