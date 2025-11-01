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
        $this->analyse([
            __DIR__ . '/Fixture/IgnoredClasses.php',
        ], [
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'Fixtures\BooleanArgumentFlag\NotIgnoredClass', 'methodWithBool', 'flag'), 16],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_FUNCTION, 'functionWithBool', 'flag'), 21],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_CLOSURE, 'flag'), 23],
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
