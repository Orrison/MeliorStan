<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessiveMethodLength;

use Orrison\MeliorStan\Rules\ExcessiveMethodLength\ExcessiveMethodLengthRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ExcessiveMethodLengthRule>
 */
class IgnoreWhitespaceTest extends RuleTestCase
{
    public function testWhitespaceAndCommentsAreIgnored(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixture/PaddedMethodClass.php',
            ],
            [
                [
                    sprintf(ExcessiveMethodLengthRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'genuinelyLongMethod', 13, 10),
                    25,
                ],
            ]
        );
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/ignore-whitespace.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ExcessiveMethodLengthRule::class);
    }
}
