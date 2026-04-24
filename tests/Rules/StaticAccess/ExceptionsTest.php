<?php

namespace Orrison\MeliorStan\Tests\Rules\StaticAccess;

use Orrison\MeliorStan\Rules\StaticAccess\StaticAccessRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<StaticAccessRule>
 */
class ExceptionsTest extends RuleTestCase
{
    public function testExceptionsExample(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExceptionsExample.php',
            __DIR__ . '/Fixture/AllowedService.php',
            __DIR__ . '/Fixture/SomeService.php',
            __DIR__ . '/Fixture/AnotherService.php',
        ], [
            [sprintf(StaticAccessRule::ERROR_MESSAGE_TEMPLATE, 'Orrison\MeliorStan\Tests\Rules\StaticAccess\Fixture\SomeService', 'process'), 10],
            [sprintf(StaticAccessRule::ERROR_MESSAGE_TEMPLATE, 'Orrison\MeliorStan\Tests\Rules\StaticAccess\Fixture\AnotherService', 'handle'), 11],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/exceptions.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(StaticAccessRule::class);
    }
}
