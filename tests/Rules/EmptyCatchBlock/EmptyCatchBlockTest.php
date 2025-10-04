<?php

namespace Orrison\MeliorStan\Tests\Rules\EmptyCatchBlock;

use Orrison\MeliorStan\Rules\EmptyCatchBlock\EmptyCatchBlockRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<EmptyCatchBlockRule>
 */
class EmptyCatchBlockTest extends RuleTestCase
{
    public static function getAdditionalConfigFiles(): array
    {
        return [
            __DIR__ . '/config/test.neon',
        ];
    }

    public function testRule(): void
    {
        $this->analyse([__DIR__ . '/Fixture/ExampleClass.php'], [
            [EmptyCatchBlockRule::ERROR_MESSAGE, 14],
            [EmptyCatchBlockRule::ERROR_MESSAGE, 23],
            [EmptyCatchBlockRule::ERROR_MESSAGE, 31],
            [EmptyCatchBlockRule::ERROR_MESSAGE, 32],
            [EmptyCatchBlockRule::ERROR_MESSAGE, 67],
        ]);
    }

    protected function getRule(): Rule
    {
        return new EmptyCatchBlockRule();
    }
}
