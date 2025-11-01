<?php

namespace Orrison\MeliorStan\Tests\Rules\BooleanArgumentFlag;

use Orrison\MeliorStan\Rules\BooleanArgumentFlag\BooleanArgumentFlagRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<BooleanArgumentFlagRule>
 */
class DefaultOptionsTest extends RuleTestCase
{
    public function testDefaultExample(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/DefaultExample.php',
        ], [
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'Fixtures\BooleanArgumentFlag\DefaultExample', '__construct', 'debug'), 7],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'Fixtures\BooleanArgumentFlag\DefaultExample', 'processWithFlag', 'flag'), 11],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'Fixtures\BooleanArgumentFlag\DefaultExample', 'handleNullable', 'option'), 15],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'Fixtures\BooleanArgumentFlag\DefaultExample', 'unionType', 'value'), 19],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'Fixtures\BooleanArgumentFlag\DefaultExample', 'multiUnion', 'mixed'), 23],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'Fixtures\BooleanArgumentFlag\DefaultExample', 'staticMethod', 'enabled'), 31],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'Fixtures\BooleanArgumentFlag\DefaultExample', '__set', 'value'), 35],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'Fixtures\BooleanArgumentFlag\DefaultExample', 'multipleParams', 'enabled'), 39],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'Fixtures\BooleanArgumentFlag\DefaultExample', 'multipleBools', 'first'), 43],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'Fixtures\BooleanArgumentFlag\DefaultExample', 'multipleBools', 'second'), 43],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'Fixtures\BooleanArgumentFlag\DefaultExample', 'protectedMethod', 'flag'), 47],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'Fixtures\BooleanArgumentFlag\DefaultExample', 'privateMethod', 'flag'), 51],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_FUNCTION, 'namedFunction', 'flag'), 56],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_CLOSURE, 'flag'), 64],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_CLOSURE, 'flag'), 68],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_CLOSURE, 'enabled'), 72],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_CLOSURE, 'outer'), 74],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_CLOSURE, 'inner'), 75],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/default.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(BooleanArgumentFlagRule::class);
    }
}
