<?php

namespace Orrison\MeliorStan\Tests\Rules\CognitiveComplexity\Fixture;

class MatchClass
{
    public function getStatus(int $code): string
    {
        return match ($code) {
            200 => 'OK',
            404 => 'Not Found',
            500 => 'Error',
            default => 'Unknown',
        };
    }
}
