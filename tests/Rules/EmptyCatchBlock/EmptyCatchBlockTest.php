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
            ['Empty catch block detected. Catch blocks should contain error handling logic.', 14],
            ['Empty catch block detected. Catch blocks should contain error handling logic.', 23],
            ['Empty catch block detected. Catch blocks should contain error handling logic.', 31],
            ['Empty catch block detected. Catch blocks should contain error handling logic.', 32],
            ['Empty catch block detected. Catch blocks should contain error handling logic.', 67],
        ]);
    }

    protected function getRule(): Rule
    {
        return new EmptyCatchBlockRule();
    }
}
