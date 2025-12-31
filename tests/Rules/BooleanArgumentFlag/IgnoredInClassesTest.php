<?php

namespace Orrison\MeliorStan\Tests\Rules\BooleanArgumentFlag;

use Orrison\MeliorStan\Rules\BooleanArgumentFlag\BooleanArgumentFlagRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<BooleanArgumentFlagRule>
 */
class IgnoredInClassesTest extends RuleTestCase
{
    public function testIgnoredClasses(): void
    {
        // IgnoredClass.php should have no errors as the class is in the ignored list
        $this->analyse([
            __DIR__ . '/Fixture/IgnoredClass.php',
        ], []);

        // NotIgnoredClass.php should have errors as the class is not in the ignored list
        $this->analyse([
            __DIR__ . '/Fixture/NotIgnoredClass.php',
        ], [
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'Orrison\MeliorStan\Tests\Rules\BooleanArgumentFlag\Fixture\NotIgnoredClass', 'methodWithBool', 'flag'), 7],
        ]);

        // Functions and closures should have errors as they are not in any class
        $this->analyse([
            __DIR__ . '/Fixture/IgnoredClassFunctions.php',
        ], [
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_FUNCTION, 'functionWithBool', 'flag'), 5],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_CLOSURE, 'flag'), 7],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/ignored-classes.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(BooleanArgumentFlagRule::class);
    }
}
