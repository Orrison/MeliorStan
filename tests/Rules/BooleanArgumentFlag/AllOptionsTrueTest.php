<?php

namespace Orrison\MeliorStan\Tests\Rules\BooleanArgumentFlag;

use Orrison\MeliorStan\Rules\BooleanArgumentFlag\BooleanArgumentFlagRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<BooleanArgumentFlagRule>
 */
class AllOptionsTrueTest extends RuleTestCase
{
    public function testAllOptions(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/AllOptions.php',
        ], [
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'Fixtures\BooleanArgumentFlag\AllOptionsNotIgnored', 'handle', 'flag'), 18],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'Fixtures\BooleanArgumentFlag\AllOptionsNotIgnored', 'processData', 'flag'), 20],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_FUNCTION, 'processConfig', 'value'), 25],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/all-options.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(BooleanArgumentFlagRule::class);
    }
}
