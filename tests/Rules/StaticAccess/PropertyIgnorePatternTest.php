<?php

namespace Orrison\MeliorStan\Tests\Rules\StaticAccess;

use Orrison\MeliorStan\Rules\StaticAccess\StaticAccessRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<StaticAccessRule>
 */
class PropertyIgnorePatternTest extends RuleTestCase
{
    public function testPropertyIgnorePatternExample(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/PropertyIgnorePatternExample.php',
            __DIR__ . '/Fixture/SomeService.php',
            __DIR__ . '/Fixture/AnotherService.php',
        ], [
            [sprintf(StaticAccessRule::ERROR_MESSAGE_TEMPLATE, 'Orrison\MeliorStan\Tests\Rules\StaticAccess\Fixture\SomeService', 'process'), 9],
            [sprintf(StaticAccessRule::ERROR_MESSAGE_TEMPLATE_PROPERTY, 'Orrison\MeliorStan\Tests\Rules\StaticAccess\Fixture\SomeService', 'value'), 10],
            [sprintf(StaticAccessRule::ERROR_MESSAGE_TEMPLATE_PROPERTY, 'Orrison\MeliorStan\Tests\Rules\StaticAccess\Fixture\AnotherService', 'count'), 11],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/property-ignore-pattern.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(StaticAccessRule::class);
    }
}
