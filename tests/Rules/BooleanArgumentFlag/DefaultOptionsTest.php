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
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'Fixtures\BooleanArgumentFlag\DefaultExample', 'processWithFlag', 'flag'), 9],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'Fixtures\BooleanArgumentFlag\DefaultExample', 'handleNullable', 'option'), 11],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'Fixtures\BooleanArgumentFlag\DefaultExample', 'unionType', 'value'), 13],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'Fixtures\BooleanArgumentFlag\DefaultExample', 'multiUnion', 'mixed'), 15],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'Fixtures\BooleanArgumentFlag\DefaultExample', 'staticMethod', 'enabled'), 19],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'Fixtures\BooleanArgumentFlag\DefaultExample', '__set', 'value'), 21],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'Fixtures\BooleanArgumentFlag\DefaultExample', 'multipleParams', 'enabled'), 23],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'Fixtures\BooleanArgumentFlag\DefaultExample', 'multipleBools', 'first'), 25],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'Fixtures\BooleanArgumentFlag\DefaultExample', 'multipleBools', 'second'), 25],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'Fixtures\BooleanArgumentFlag\DefaultExample', 'protectedMethod', 'flag'), 27],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_METHOD, 'Fixtures\BooleanArgumentFlag\DefaultExample', 'privateMethod', 'flag'), 29],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_FUNCTION, 'namedFunction', 'flag'), 32],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_CLOSURE, 'flag'), 36],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_CLOSURE, 'flag'), 40],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_CLOSURE, 'enabled'), 44],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_CLOSURE, 'outer'), 46],
            [sprintf(BooleanArgumentFlagRule::ERROR_MESSAGE_TEMPLATE_CLOSURE, 'inner'), 47],
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
