<?php

namespace Orrison\MessedUpPhpstan\Tests\Rules\ShortParameter;

use Orrison\MessedUpPhpstan\Rules\ShortParameter\ShortParameterRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ShortParameterRule>
 */
class DefaultOptionsTest extends RuleTestCase
{
    public function testExampleClass(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExampleClass.php',
        ], [
            ['Parameter name "$a" is shorter than minimum length of 3 characters.', 18],
            ['Parameter name "$id" is shorter than minimum length of 3 characters.', 18],
            ['Parameter name "$b" is shorter than minimum length of 3 characters.', 26],
            ['Parameter name "$x" is shorter than minimum length of 3 characters.', 31],
            ['Parameter name "$y" is shorter than minimum length of 3 characters.', 31],
            ['Parameter name "$c" is shorter than minimum length of 3 characters.', 42],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/configured_rule.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ShortParameterRule::class);
    }
}
