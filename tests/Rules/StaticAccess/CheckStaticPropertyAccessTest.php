<?php

namespace Orrison\MeliorStan\Tests\Rules\StaticAccess;

use Orrison\MeliorStan\Rules\StaticAccess\StaticAccessRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<StaticAccessRule>
 */
class CheckStaticPropertyAccessTest extends RuleTestCase
{
    public function testStaticPropertyAccessExample(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/StaticPropertyAccessExample.php',
            __DIR__ . '/Fixture/SomeService.php',
            __DIR__ . '/Fixture/AnotherService.php',
        ], [
            [sprintf(StaticAccessRule::ERROR_MESSAGE_TEMPLATE, 'Orrison\MeliorStan\Tests\Rules\StaticAccess\Fixture\SomeService', 'process'), 11],
            [sprintf(StaticAccessRule::ERROR_MESSAGE_TEMPLATE_PROPERTY, 'Orrison\MeliorStan\Tests\Rules\StaticAccess\Fixture\SomeService', 'value'), 12],
            [sprintf(StaticAccessRule::ERROR_MESSAGE_TEMPLATE_PROPERTY, 'Orrison\MeliorStan\Tests\Rules\StaticAccess\Fixture\AnotherService', 'count'), 13],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/check-static-property-access.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(StaticAccessRule::class);
    }
}
