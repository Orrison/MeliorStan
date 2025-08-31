<?php

namespace Orrison\MeliorStan\Tests\Rules\CamelCasePropertyName;

use Orrison\MeliorStan\Rules\CamelCasePropertyName\CamelCasePropertyNameRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<CamelCasePropertyNameRule>
 */
class IgnoredWhenInClassesTest extends RuleTestCase
{
    public function testIgnoredClasses(): void
    {
        // Test IgnoredParentClass - should produce error (not ignored)
        $this->analyse([
            __DIR__ . '/Fixture/IgnoredParentClass.php',
        ], [
            ['Property name "some_property" is not in camelCase.', 7],
        ]);

        // Test IgnoredClass - should produce no error (ignored)
        $this->analyse([
            __DIR__ . '/Fixture/IgnoredClass.php',
        ], [
            // No errors expected
        ]);

        // Test NotIgnoredClass - should produce error (not ignored)
        $this->analyse([
            __DIR__ . '/Fixture/NotIgnoredClass.php',
        ], [
            ['Property name "yet_another_property" is not in camelCase.', 7],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/ignored_when_in_classes.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(CamelCasePropertyNameRule::class);
    }
}
