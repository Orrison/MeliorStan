<?php

namespace Orrison\MessedUpPhpstan\Tests\Rules\ShortProperty;

use Orrison\MessedUpPhpstan\Rules\ShortProperty\ShortPropertyRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ShortPropertyRule>
 */
class DefaultOptionsTest extends RuleTestCase
{
    public function testExampleClass(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExampleClass.php',
        ], [
            ['Property name "$x" is shorter than minimum length of 3 characters.', 7],
            ['Property name "$id" is shorter than minimum length of 3 characters.', 9],
            ['Property name "$y" is shorter than minimum length of 3 characters.', 30],
            ['Property name "$z" is shorter than minimum length of 3 characters.', 34],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/configured_rule.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ShortPropertyRule::class);
    }
}
