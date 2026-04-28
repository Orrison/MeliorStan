<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessiveClassComplexity;

use Orrison\MeliorStan\Rules\ExcessiveClassComplexity\ExcessiveClassComplexityRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ExcessiveClassComplexityRule>
 */
class DefaultOptionsTest extends RuleTestCase
{
    public function testHighComplexityClassTriggersError(): void
    {
        $this->analyse(
            [__DIR__ . '/Fixture/HighComplexityClass.php'],
            [
                [
                    sprintf(ExcessiveClassComplexityRule::ERROR_MESSAGE_TEMPLATE, 'Class "HighComplexityClass"', 55, 50),
                    5,
                ],
            ]
        );
    }

    public function testLowComplexityClassNoError(): void
    {
        $this->analyse([__DIR__ . '/Fixture/LowComplexityClass.php'], []);
    }

    public function testHighComplexityTraitTriggersError(): void
    {
        $this->analyse(
            [__DIR__ . '/Fixture/HighComplexityTrait.php'],
            [
                [
                    sprintf(ExcessiveClassComplexityRule::ERROR_MESSAGE_TEMPLATE, 'Trait "HighComplexityTrait"', 55, 50),
                    5,
                ],
            ]
        );
    }

    public function testHighComplexityEnumTriggersError(): void
    {
        $this->analyse(
            [__DIR__ . '/Fixture/HighComplexityEnum.php'],
            [
                [
                    sprintf(ExcessiveClassComplexityRule::ERROR_MESSAGE_TEMPLATE, 'Enum "HighComplexityEnum"', 55, 50),
                    5,
                ],
            ]
        );
    }

    public function testHighComplexityAnonymousClassTriggersError(): void
    {
        $this->analyse(
            [__DIR__ . '/Fixture/AnonymousClassHolder.php'],
            [
                [
                    sprintf(ExcessiveClassComplexityRule::ERROR_MESSAGE_TEMPLATE, 'Anonymous class', 55, 50),
                    5,
                ],
            ]
        );
    }

    public function testLowComplexityAnonymousClassNoError(): void
    {
        $this->analyse([__DIR__ . '/Fixture/SimpleAnonymousClassHolder.php'], []);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/default.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ExcessiveClassComplexityRule::class);
    }
}
