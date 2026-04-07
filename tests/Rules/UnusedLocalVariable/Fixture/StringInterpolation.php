<?php

namespace Orrison\MeliorStan\Tests\Rules\UnusedLocalVariable\Fixture;

class StringInterpolation
{
    public function greet(): string
    {
        $name = 'world';
        $dead = 'unused';

        return "hello {$name}";
    }

    public function complexInterpolation(): string
    {
        $user = (object) ['name' => 'alice'];

        return "hi {$user->name}";
    }
}
