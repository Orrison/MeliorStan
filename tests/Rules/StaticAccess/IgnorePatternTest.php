<?php

namespace Orrison\MeliorStan\Tests\Rules\StaticAccess;

use Orrison\MeliorStan\Rules\StaticAccess\StaticAccessRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<StaticAccessRule>
 */
class IgnorePatternTest extends RuleTestCase
{
    public function testIgnorePatternExample(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/IgnorePatternExample.php',
            __DIR__ . '/Fixture/SomeService.php',
            __DIR__ . '/Fixture/AnotherService.php',
        ], [
            [sprintf(StaticAccessRule::ERROR_MESSAGE_TEMPLATE, 'Orrison\MeliorStan\Tests\Rules\StaticAccess\Fixture\SomeService', 'process'), 12],
            [sprintf(StaticAccessRule::ERROR_MESSAGE_TEMPLATE, 'Orrison\MeliorStan\Tests\Rules\StaticAccess\Fixture\AnotherService', 'handle'), 13],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/ignore-pattern.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(StaticAccessRule::class);
    }
}
