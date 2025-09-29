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
            ['Method name "ExampleClass" is the same as the enclosing class "ExampleClass". This creates confusion as it resembles a PHP4-style constructor.', 14],
            ['Method name "AnotherExample" is the same as the enclosing class "AnotherExample". This creates confusion as it resembles a PHP4-style constructor.', 23],
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
