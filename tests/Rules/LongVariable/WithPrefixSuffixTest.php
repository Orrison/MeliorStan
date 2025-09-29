<?php

namespace Orrison\MeliorStan\Tests\Rules\LongVariable;

use Orrison\MeliorStan\Rules\LongVariable\LongVariableRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<LongVariableRule>
 */
class WithPrefixSuffixTest extends RuleTestCase
{
    public function testExampleClass(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExampleClass.php',
        ], [
            // "anotherVeryLongPropertyNameThatIsAlsoTooLong" has no matching prefix, so full length 44 > 20
            ['Property name "$anotherVeryLongPropertyNameThatIsAlsoTooLong" is 44 characters long, which exceeds the maximum of 20 characters.', 11],
            // "veryLongParameterNameThatExceedsTheMaximumLength" becomes "ParameterName" after prefix+suffix subtraction = 12 chars < 20, so no violation
            // "anotherVeryLongParameterNameThatIsAlsoTooLong" has no matching prefix, so full length 45 > 20
            ['Parameter name "$anotherVeryLongParameterNameThatIsAlsoTooLong" is 45 characters long, which exceeds the maximum of 20 characters.', 15],
            // "veryLongVariableNameThatExceedsTheMaximumLength" becomes "VariableName" = 12 chars < 20, so no violation
            // "anotherVeryLongVariableNameThatIsAlsoTooLong" has no matching prefix, so full length 44 > 20
            ['Variable name "$anotherVeryLongVariableNameThatIsAlsoTooLong" is 44 characters long, which exceeds the maximum of 20 characters.', 18],
            // "veryLongLoopVariableNameThatExceedsTheMaximumLength" becomes "LoopVariableName" = 16 chars < 20, so no violation
            // "anotherVeryLongLoopVariableNameThatIsAlsoTooLong" has no matching prefix, so full length 48 > 20
            ['Variable name "$anotherVeryLongLoopVariableNameThatIsAlsoTooLong" is 48 characters long, which exceeds the maximum of 20 characters.', 22],
            // "veryLongKeyVariableNameThatExceedsTheMaximumLength" becomes "KeyVariableName" = 15 chars < 20, so no violation
            // "veryLongValueVariableNameThatExceedsTheMaximumLength" becomes "ValueVariableName" = 17 chars < 20, so no violation
            // "veryLongExceptionVariableNameThatExceedsTheMaximumLength" becomes "ExceptionVariableName" = 21 chars > 20
            ['Variable name "$veryLongExceptionVariableNameThatExceedsTheMaximumLength" is 21 characters long, which exceeds the maximum of 20 characters.', 33],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [
            __DIR__ . '/config/configured_rule.neon',
            __DIR__ . '/config/with_prefix_suffix.neon',
        ];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(LongVariableRule::class);
    }
}
