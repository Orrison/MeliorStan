<?php

declare(strict_types = 1);

namespace Orrison\MessedUpPhpstan\Tests\Rules\Superglobals;

use Orrison\MessedUpPhpstan\Rules\Superglobals\SuperglobalsRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<SuperglobalsRule>
 */
class DefaultOptionsTest extends RuleTestCase
{
    public function testExampleClass(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExampleClass.php',
        ], [
            ['Superglobal "$_SERVER" should not be used in userland code.', 10],
            ['Superglobal "$_GET" should not be used in userland code.', 11],
            ['Superglobal "$_POST" should not be used in userland code.', 12],
            ['Superglobal "$_FILES" should not be used in userland code.', 13],
            ['Superglobal "$_COOKIE" should not be used in userland code.', 14],
            ['Superglobal "$_SESSION" should not be used in userland code.', 15],
            ['Superglobal "$_REQUEST" should not be used in userland code.', 16],
            ['Superglobal "$_ENV" should not be used in userland code.', 17],
            ['Superglobal "$GLOBALS" should not be used in userland code.', 18],
            ['Superglobal "$_GET" should not be used in userland code.', 33],
            ['Superglobal "$_POST" should not be used in userland code.', 34],
            ['Superglobal "$_COOKIE" should not be used in userland code.', 37],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/configured_rule.neon'];
    }

    protected function getRule(): Rule
    {
        return new SuperglobalsRule();
    }
}
