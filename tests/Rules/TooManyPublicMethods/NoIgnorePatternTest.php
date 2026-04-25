<?php

namespace Orrison\MeliorStan\Tests\Rules\TooManyPublicMethods;

use Orrison\MeliorStan\Rules\TooManyPublicMethods\TooManyPublicMethodsRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<TooManyPublicMethodsRule>
 */
class NoIgnorePatternTest extends RuleTestCase
{
    public function testRule(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixture/ClassWithGettersExceedingLimit.php',
            ],
            [
                [
                    sprintf(TooManyPublicMethodsRule::ERROR_MESSAGE_TEMPLATE, 'Class', 'ClassWithGettersExceedingLimit', 11, 10),
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
        return [__DIR__ . '/config/no_ignore_pattern.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(TooManyPublicMethodsRule::class);
    }
}
