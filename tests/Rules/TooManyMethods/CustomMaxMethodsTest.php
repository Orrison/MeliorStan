<?php

namespace Orrison\MeliorStan\Tests\Rules\TooManyMethods;

use Orrison\MeliorStan\Rules\TooManyMethods\TooManyMethodsRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * Tests with custom max_methods=5
 *
 * @extends RuleTestCase<TooManyMethodsRule>
 */
class CustomMaxMethodsTest extends RuleTestCase
{
    public function testRule(): void
    {
        $this->analyse([__DIR__ . '/Fixture/ExampleClass.php'], [
            [
                sprintf(TooManyMethodsRule::ERROR_MESSAGE_TEMPLATE, 'Class', 'ClassWithManyMethods', 10, 5),
                15,
            ],
            [
                sprintf(TooManyMethodsRule::ERROR_MESSAGE_TEMPLATE, 'Class', 'ClassExceedingLimit', 26, 5),
                127,
            ],
            [
                sprintf(TooManyMethodsRule::ERROR_MESSAGE_TEMPLATE, 'Trait', 'TraitExceedingLimit', 26, 5),
                203,
            ],
            [
                sprintf(TooManyMethodsRule::ERROR_MESSAGE_TEMPLATE, 'Interface', 'InterfaceExceedingLimit', 26, 5),
                262,
            ],
            [
                sprintf(TooManyMethodsRule::ERROR_MESSAGE_TEMPLATE, 'Enum', 'EnumExceedingLimit', 26, 5),
                321,
            ],
            [
                sprintf(TooManyMethodsRule::ERROR_MESSAGE_TEMPLATE, 'Class', 'ClassWithSixMethods', 6, 5),
                381,
            ],
        ]);
    }

    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/custom_max_methods.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(TooManyMethodsRule::class);
    }
}
