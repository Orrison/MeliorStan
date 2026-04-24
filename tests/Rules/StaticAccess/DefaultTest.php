<?php

namespace Orrison\MeliorStan\Tests\Rules\StaticAccess;

use Orrison\MeliorStan\Rules\StaticAccess\StaticAccessRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<StaticAccessRule>
 */
class DefaultTest extends RuleTestCase
{
    public function testDefaultExample(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/DefaultExample.php',
            __DIR__ . '/Fixture/BaseExample.php',
            __DIR__ . '/Fixture/SomeService.php',
            __DIR__ . '/Fixture/AnotherService.php',
        ], [
            [sprintf(StaticAccessRule::ERROR_MESSAGE_TEMPLATE, 'Orrison\MeliorStan\Tests\Rules\StaticAccess\Fixture\SomeService', 'process'), 11],
            [sprintf(StaticAccessRule::ERROR_MESSAGE_TEMPLATE, 'Orrison\MeliorStan\Tests\Rules\StaticAccess\Fixture\AnotherService', 'handle'), 12],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/default.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(StaticAccessRule::class);
    }
}
