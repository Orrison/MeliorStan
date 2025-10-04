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
            [sprintf(LongVariableRule::ERROR_MESSAGE_TEMPLATE_PROPERTY, 'veryLongPropertyNameThatExceedsTheMaximumLength', 47, 20), 9],
            [sprintf(LongVariableRule::ERROR_MESSAGE_TEMPLATE_PROPERTY, 'anotherVeryLongPropertyNameThatIsAlsoTooLong', 44, 20), 11],
            [sprintf(LongVariableRule::ERROR_MESSAGE_TEMPLATE_PARAMETER, 'veryLongParameterNameThatExceedsTheMaximumLength', 48, 20), 15],
            [sprintf(LongVariableRule::ERROR_MESSAGE_TEMPLATE_PARAMETER, 'anotherVeryLongParameterNameThatIsAlsoTooLong', 45, 20), 15],
            [sprintf(LongVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'veryLongVariableNameThatExceedsTheMaximumLength', 47, 20), 17],
            [sprintf(LongVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'anotherVeryLongVariableNameThatIsAlsoTooLong', 44, 20), 18],
            [sprintf(LongVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'veryLongLoopVariableNameThatExceedsTheMaximumLength', 51, 20), 21],
            [sprintf(LongVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'anotherVeryLongLoopVariableNameThatIsAlsoTooLong', 48, 20), 22],
            [sprintf(LongVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'veryLongKeyVariableNameThatExceedsTheMaximumLength', 50, 20), 27],
            [sprintf(LongVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'veryLongValueVariableNameThatExceedsTheMaximumLength', 52, 20), 27],
            [sprintf(LongVariableRule::ERROR_MESSAGE_TEMPLATE_VARIABLE, 'veryLongExceptionVariableNameThatExceedsTheMaximumLength', 56, 20), 33],
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
