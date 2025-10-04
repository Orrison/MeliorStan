<?php

namespace Orrison\MeliorStan\Tests\Rules\ConstructorWithNameAsEnclosingClass;

use Orrison\MeliorStan\Rules\ConstructorWithNameAsEnclosingClass\ConstructorWithNameAsEnclosingClassRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ConstructorWithNameAsEnclosingClassRule>
 */
class DefaultOptionsTest extends RuleTestCase
{
    public function testExampleClass(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExampleClass.php',
        ], [
            [sprintf(ConstructorWithNameAsEnclosingClassRule::ERROR_MESSAGE_TEMPLATE, 'ExampleClass', 'ExampleClass'), 14],
            [sprintf(ConstructorWithNameAsEnclosingClassRule::ERROR_MESSAGE_TEMPLATE, 'AnotherExample', 'AnotherExample'), 23],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/configured_rule.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ConstructorWithNameAsEnclosingClassRule::class);
    }
}
