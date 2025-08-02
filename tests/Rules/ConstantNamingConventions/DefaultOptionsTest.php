<?php

namespace Orrison\MessedUpPhpstan\Tests\Rules\ConstantNamingConventions;

use Orrison\MessedUpPhpstan\Rules\ConstantNamingConventions\ConstantNamingConventionsRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ConstantNamingConventionsRule>
 */
class DefaultOptionsTest extends RuleTestCase
{
    public function testExampleClass(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExampleClass.php',
        ], [
            ['Constant name "maxConnections" is not in UPPERCASE.', 19],
            ['Constant name "Default_Timeout" is not in UPPERCASE.', 21],
            ['Constant name "api_version" is not in UPPERCASE.', 23],
            ['Constant name "InternalFlag" is not in UPPERCASE.', 25],
            ['Constant name "bufferSize" is not in UPPERCASE.', 27],
            ['Constant name "MIXED_case" is not in UPPERCASE.', 29],
            ['Constant name "lowercase" is not in UPPERCASE.', 31],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/configured_rule.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ConstantNamingConventionsRule::class);
    }
}
