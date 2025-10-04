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
            [sprintf(LongVariableRule::ERROR_MESSAGE_TEMPLATE_PROPERTY, 'anotherVeryLongPropertyNameThatIsAlsoTooLong', 44, 20), 11],
            // "veryLongParameterNameThatExceedsTheMaximumLength" becomes "ParameterName" after prefix+suffix subtraction = 12 chars < 20, so no violation
            // "anotherVeryLongParameterNameThatIsAlsoTooLong" has no matching prefix, so full length 45 > 20
            [sprintf(LongVariableRule::ERROR_MESSAGE_TEMPLATE_PARAMETER, 'anotherVeryLongParameterNameThatIsAlsoTooLong', 45, 20), 15],
            // "veryLongVariableNameThatExceedsTheMaximumLength" becomes "VariableName" = 12 chars < 20, so no violation
            // "anotherVeryLongVariableNameThatIsAlsoTooLong" has no matching prefix, so full length 44 > 20
            [sprintf(LongVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'anotherVeryLongVariableNameThatIsAlsoTooLong', 44, 20), 18],
            // "veryLongLoopVariableNameThatExceedsTheMaximumLength" becomes "LoopVariableName" = 16 chars < 20, so no violation
            // "anotherVeryLongLoopVariableNameThatIsAlsoTooLong" has no matching prefix, so full length 48 > 20
            [sprintf(LongVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'anotherVeryLongLoopVariableNameThatIsAlsoTooLong', 48, 20), 22],
            // "veryLongKeyVariableNameThatExceedsTheMaximumLength" becomes "KeyVariableName" = 15 chars < 20, so no violation
            // "veryLongValueVariableNameThatExceedsTheMaximumLength" becomes "ValueVariableName" = 17 chars < 20, so no violation
            // "veryLongExceptionVariableNameThatExceedsTheMaximumLength" becomes "ExceptionVariableName" = 21 chars > 20
            [sprintf(LongVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'veryLongExceptionVariableNameThatExceedsTheMaximumLength', 21, 20), 33],
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
