<?php

declare(strict_types = 1);

namespace Orrison\MessedUpPhpstan\Tests\Rules\CamelCasePropertyName;

use Orrison\MessedUpPhpstan\Rules\CamelCasePropertyName\CamelCasePropertyNameRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<CamelCasePropertyNameRule>
 */
class AllOptionsTrueTest extends RuleTestCase
{
    public function testExampleClass(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExampleClass.php',
        ], [
            ['Property name "$invalid_property" is not in camelCase.', 10],
            ['Property name "$InvalidProperty" is not in camelCase.', 11],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/all_options_true.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(CamelCasePropertyNameRule::class);
    }
}
