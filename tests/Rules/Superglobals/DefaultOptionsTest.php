<?php

namespace Orrison\MeliorStan\Tests\Rules\Superglobals;

use Orrison\MeliorStan\Rules\Superglobals\SuperglobalsRule;
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
            [sprintf(SuperglobalsRule::ERROR_MESSAGE_TEMPLATE, '_SERVER'), 10],
            [sprintf(SuperglobalsRule::ERROR_MESSAGE_TEMPLATE, '_GET'), 11],
            [sprintf(SuperglobalsRule::ERROR_MESSAGE_TEMPLATE, '_POST'), 12],
            [sprintf(SuperglobalsRule::ERROR_MESSAGE_TEMPLATE, '_FILES'), 13],
            [sprintf(SuperglobalsRule::ERROR_MESSAGE_TEMPLATE, '_COOKIE'), 14],
            [sprintf(SuperglobalsRule::ERROR_MESSAGE_TEMPLATE, '_SESSION'), 15],
            [sprintf(SuperglobalsRule::ERROR_MESSAGE_TEMPLATE, '_REQUEST'), 16],
            [sprintf(SuperglobalsRule::ERROR_MESSAGE_TEMPLATE, '_ENV'), 17],
            [sprintf(SuperglobalsRule::ERROR_MESSAGE_TEMPLATE, 'GLOBALS'), 18],
            [sprintf(SuperglobalsRule::ERROR_MESSAGE_TEMPLATE, '_GET'), 33],
            [sprintf(SuperglobalsRule::ERROR_MESSAGE_TEMPLATE, '_POST'), 34],
            [sprintf(SuperglobalsRule::ERROR_MESSAGE_TEMPLATE, '_COOKIE'), 37],
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
