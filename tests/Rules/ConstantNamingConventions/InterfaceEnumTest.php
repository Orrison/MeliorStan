<?php

namespace Orrison\MessedUpPhpstan\Tests\Rules\ConstantNamingConventions;

use Orrison\MessedUpPhpstan\Rules\ConstantNamingConventions\ConstantNamingConventionsRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ConstantNamingConventionsRule>
 */
class InterfaceEnumTest extends RuleTestCase
{
    public function testInterfaceEnum(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/InterfaceEnum.php',
        ], [
            ['Constant name "interfaceConstant" is not in UPPERCASE.', 9],
            ['Constant name "enumConstant" is not in UPPERCASE.', 16],
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
