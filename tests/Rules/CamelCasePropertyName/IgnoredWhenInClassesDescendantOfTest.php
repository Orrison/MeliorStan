<?php

namespace Orrison\MeliorStan\Tests\Rules\CamelCasePropertyName;

use Orrison\MeliorStan\Rules\CamelCasePropertyName\CamelCasePropertyNameRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<CamelCasePropertyNameRule>
 */
class IgnoredWhenInClassesDescendantOfTest extends RuleTestCase
{
    public function testIgnoredDescendants(): void
    {
        // Test IgnoredParentClass - should produce no error (parent class ignored)
        $this->analyse([
            __DIR__ . '/Fixture/IgnoredParentClass.php',
        ], [
            // No errors expected
        ]);

        // Test IgnoredClass - should produce no error (extends ignored parent)
        $this->analyse([
            __DIR__ . '/Fixture/IgnoredClass.php',
        ], [
            // No errors expected
        ]);

        // Test NotIgnoredClass - should produce error (not ignored)
        $this->analyse([
            __DIR__ . '/Fixture/NotIgnoredClass.php',
        ], [
            [sprintf(CamelCasePropertyNameRule::ERROR_MESSAGE_TEMPLATE, 'yet_another_property'), 7],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/ignored_when_in_classes_descendant_of.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(CamelCasePropertyNameRule::class);
    }
}
