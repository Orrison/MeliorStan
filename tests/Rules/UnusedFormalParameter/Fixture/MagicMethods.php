<?php

namespace Orrison\MeliorStan\Tests\Rules\UnusedFormalParameter\Fixture;

class MagicMethods
{
    public function __call(string $name, array $args): void {}

    public function __set(string $name, mixed $value): void {}

    public function __get(string $name): mixed
    {
        return null;
    }
}
