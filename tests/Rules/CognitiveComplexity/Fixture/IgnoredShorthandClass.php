<?php

namespace Orrison\MeliorStan\Tests\Rules\CognitiveComplexity\Fixture;

class IgnoredShorthandClass
{
    public function process(?string $a, ?Helper $obj): string
    {
        $value = $a ?? 'default';
        $result = $obj?->method() ?? 'fallback';
        $a ??= 'init';

        return $value . $result;
    }
}
