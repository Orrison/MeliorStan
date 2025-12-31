<?php

namespace Orrison\MeliorStan\Tests\Rules\TooManyMethods;

use Orrison\MeliorStan\Rules\TooManyMethods\TooManyMethodsRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<TooManyMethodsRule>
 */
class TooManyMethodsRuleTest extends RuleTestCase
{
    public function testRule(): void
    {
        $this->analyse([__DIR__ . '/Fixture/ExampleClass.php'], [
            [
                sprintf(TooManyMethodsRule::ERROR_MESSAGE_TEMPLATE, 'Class', 'ClassExceedingLimit', 26, 25),
                127,
            ],
            [
                sprintf(TooManyMethodsRule::ERROR_MESSAGE_TEMPLATE, 'Trait', 'TraitExceedingLimit', 26, 25),
                203,
            ],
            [
                sprintf(TooManyMethodsRule::ERROR_MESSAGE_TEMPLATE, 'Interface', 'InterfaceExceedingLimit', 26, 25),
                262,
            ],
            [
                sprintf(TooManyMethodsRule::ERROR_MESSAGE_TEMPLATE, 'Enum', 'EnumExceedingLimit', 26, 25),
                321,
            ],
        ]);
    }

    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/configured_rule.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(TooManyMethodsRule::class);
    }
}
