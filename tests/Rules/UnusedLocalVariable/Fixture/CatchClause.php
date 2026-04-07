<?php

namespace Orrison\MeliorStan\Tests\Rules\UnusedLocalVariable\Fixture;

use RuntimeException;

class CatchClause
{
    public function swallowException(): void
    {
        try {
            throw new RuntimeException('boom');
        } catch (RuntimeException $e) {
            // intentionally empty
        }
    }
}
