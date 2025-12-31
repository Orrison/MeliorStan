<?php

namespace Orrison\MeliorStan\Tests\Rules\BooleanArgumentFlag;

use Orrison\MeliorStan\Rules\BooleanArgumentFlag\BooleanArgumentFlagRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<BooleanArgumentFlagRule>
 */
class IgnorePatternTest extends RuleTestCase
{
    public function testIgnorePattern(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/IgnorePatternExample.php',
        ], [
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'Orrison\MeliorStan\Tests\Rules\BooleanArgumentFlag\Fixture\IgnorePatternExample', 'processWithFlag', 'flag'), 13],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'Orrison\MeliorStan\Tests\Rules\BooleanArgumentFlag\Fixture\IgnorePatternExample', 'handleBool', 'value'), 15],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_FUNCTION, 'processGlobal', 'value'), 24],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_CLOSURE, 'value'), 26],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_CLOSURE, 'value'), 28],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/ignore-pattern.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(BooleanArgumentFlagRule::class);
    }
}
