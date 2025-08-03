<?php

namespace Orrison\MessedUpPhpstan\Tests\Rules\BooleanGetMethodName;

use Orrison\MessedUpPhpstan\Rules\BooleanGetMethodName\BooleanGetMethodNameRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<BooleanGetMethodNameRule>
 */
class DefaultOptionsTest extends RuleTestCase
{
    public function testExampleClass(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExampleClass.php',
        ], [
            ['Method "getBooleanValue" starts with "get" and returns boolean, consider using "is" or "has" instead.', 8],
            ['Method "getIsValid" starts with "get" and returns boolean, consider using "is" or "has" instead.', 13],
            ['Method "getFlag" starts with "get" and returns boolean, consider using "is" or "has" instead.', 21],
            ['Method "getEnabled" starts with "get" and returns boolean, consider using "is" or "has" instead.', 29],
            ['Method "_getPrivateBoolean" starts with "get" and returns boolean, consider using "is" or "has" instead.', 91],
            ['Method "GetCamelCase" starts with "get" and returns boolean, consider using "is" or "has" instead.', 96],
            ['Method "getTrue" starts with "get" and returns boolean, consider using "is" or "has" instead.', 111],
            ['Method "getFalse" starts with "get" and returns boolean, consider using "is" or "has" instead.', 116],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [
            __DIR__ . '/config/default_options.neon',
        ];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(BooleanGetMethodNameRule::class);
    }
}
