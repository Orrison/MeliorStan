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
        // AllOptionsIgnoredClass.php should have no errors as the class is in the ignored list
        $this->analyse([
            __DIR__ . '/Fixture/AllOptionsIgnoredClass.php',
        ], []);

        // AllOptionsNotIgnored.php - setOption is ignored by pattern, but handle and processData should error
        $this->analyse([
            __DIR__ . '/Fixture/AllOptionsNotIgnored.php',
        ], [
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'Orrison\MeliorStan\Tests\Rules\BooleanArgumentFlag\Fixture\AllOptionsNotIgnored', 'handle', 'flag'), 9],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'Orrison\MeliorStan\Tests\Rules\BooleanArgumentFlag\Fixture\AllOptionsNotIgnored', 'processData', 'flag'), 11],
        ]);

        // AllOptionsFunctions.php - setConfig is ignored by pattern, but processConfig should error
        $this->analyse([
            __DIR__ . '/Fixture/AllOptionsFunctions.php',
        ], [
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_FUNCTION, 'processConfig', 'value'), 7],
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
