<?php

namespace Orrison\MeliorStan\Tests\Rules\StaticAccess;

use Orrison\MeliorStan\Rules\StaticAccess\StaticAccessRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<StaticAccessRule>
 */
class ExceptionsWildcardTest extends RuleTestCase
{
    public function testExceptionsWildcardExample(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExceptionsWildcardExample.php',
            __DIR__ . '/Fixture/Helpers/StringHelper.php',
            __DIR__ . '/Fixture/Helpers/ArrayHelper.php',
            __DIR__ . '/Fixture/SomeService.php',
        ], [
            [sprintf(StaticAccessRule::ERROR_MESSAGE_TEMPLATE, 'Orrison\MeliorStan\Tests\Rules\StaticAccess\Fixture\SomeService', 'process'), 14],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/exceptions-wildcard.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(StaticAccessRule::class);
    }
}
