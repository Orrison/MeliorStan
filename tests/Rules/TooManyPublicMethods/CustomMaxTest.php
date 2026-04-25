<?php

namespace Orrison\MeliorStan\Tests\Rules\TooManyPublicMethods;

use Orrison\MeliorStan\Rules\TooManyPublicMethods\TooManyPublicMethodsRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<TooManyPublicMethodsRule>
 */
class CustomMaxTest extends RuleTestCase
{
    public function testRule(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixture/ClassExceedingCustomLimit.php',
            ],
            [
                [
                    sprintf(TooManyPublicMethodsRule::ERROR_MESSAGE_TEMPLATE, 'Class', 'ClassExceedingCustomLimit', 6, 5),
                    6,
                ],
            ]
        );
    }

    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/custom_max.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(TooManyPublicMethodsRule::class);
    }
}
