<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessiveMethodLength;

use Orrison\MeliorStan\Rules\ExcessiveMethodLength\ExcessiveMethodLengthRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ExcessiveMethodLengthRule>
 */
class IgnorePatternTest extends RuleTestCase
{
    public function testIgnoredMethodNamesAreSkipped(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixture/LaravelStyleClass.php',
            ],
            [
                [
                    sprintf(ExcessiveMethodLengthRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'notIgnoredMethod', 13, 10),
                    35,
                ],
            ]
        );
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/ignore-pattern.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ExcessiveMethodLengthRule::class);
    }
}
