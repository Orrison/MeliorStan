<?php

namespace Orrison\MeliorStan\Tests\Rules\ConstantNamingConventions;

use Orrison\MeliorStan\Rules\ConstantNamingConventions\ConstantNamingConventionsRule;
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
            [sprintf(ConstantNamingConventionsRule::ERROR_MESSAGE_TEMPLATE, 'interfaceConstant'), 9],
            [sprintf(ConstantNamingConventionsRule::ERROR_MESSAGE_TEMPLATE, 'enumConstant'), 16],
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
