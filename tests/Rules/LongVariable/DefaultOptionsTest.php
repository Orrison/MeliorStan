<?php

namespace Orrison\MeliorStan\Tests\Rules\LongVariable;

use Orrison\MeliorStan\Rules\LongVariable\LongVariableRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<LongVariableRule>
 */
class DefaultOptionsTest extends RuleTestCase
{
    public function testExampleClass(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExampleClass.php',
        ], [
            ['Property name "$veryLongPropertyNameThatExceedsTheMaximumLength" is 47 characters long, which exceeds the maximum of 20 characters.', 9],
            ['Property name "$anotherVeryLongPropertyNameThatIsAlsoTooLong" is 44 characters long, which exceeds the maximum of 20 characters.', 11],
            ['Parameter name "$veryLongParameterNameThatExceedsTheMaximumLength" is 48 characters long, which exceeds the maximum of 20 characters.', 15],
            ['Parameter name "$anotherVeryLongParameterNameThatIsAlsoTooLong" is 45 characters long, which exceeds the maximum of 20 characters.', 15],
            ['Variable name "$veryLongVariableNameThatExceedsTheMaximumLength" is 47 characters long, which exceeds the maximum of 20 characters.', 17],
            ['Variable name "$anotherVeryLongVariableNameThatIsAlsoTooLong" is 44 characters long, which exceeds the maximum of 20 characters.', 18],
            ['Variable name "$veryLongLoopVariableNameThatExceedsTheMaximumLength" is 51 characters long, which exceeds the maximum of 20 characters.', 21],
            ['Variable name "$anotherVeryLongLoopVariableNameThatIsAlsoTooLong" is 48 characters long, which exceeds the maximum of 20 characters.', 22],
            ['Variable name "$veryLongKeyVariableNameThatExceedsTheMaximumLength" is 50 characters long, which exceeds the maximum of 20 characters.', 27],
            ['Variable name "$veryLongValueVariableNameThatExceedsTheMaximumLength" is 52 characters long, which exceeds the maximum of 20 characters.', 27],
            ['Variable name "$veryLongExceptionVariableNameThatExceedsTheMaximumLength" is 56 characters long, which exceeds the maximum of 20 characters.', 33],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/configured_rule.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(LongVariableRule::class);
    }
}
