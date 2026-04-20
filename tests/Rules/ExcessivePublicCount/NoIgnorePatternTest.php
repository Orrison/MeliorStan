<?php

namespace Orrison\MeliorStan\Tests\Rules\ExcessivePublicCount;

use Orrison\MeliorStan\Rules\ExcessivePublicCount\ExcessivePublicCountRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ExcessivePublicCountRule>
 */
class NoIgnorePatternTest extends RuleTestCase
{
    public function testRule(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixture/SmallDtoWithGetters.php',
            ],
            [
                [
                    sprintf(ExcessivePublicCountRule::ERROR_MESSAGE_TEMPLATE, 'Class', 'SmallDtoWithGetters', 6, 6, 0, 5),
                    9,
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
        return self::getContainer()->getByType(ExcessivePublicCountRule::class);
    }
}
