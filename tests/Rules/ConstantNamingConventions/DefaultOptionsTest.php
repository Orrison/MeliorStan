<?php

namespace Orrison\MeliorStan\Tests\Rules\ConstantNamingConventions;

use Orrison\MeliorStan\Rules\ConstantNamingConventions\ConstantNamingConventionsRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ConstantNamingConventionsRule>
 */
class DefaultOptionsTest extends RuleTestCase
{
    public function testExampleClass(): void
    {
        $this->analyse([
            __DIR__ . '/Fixture/ExampleClass.php',
        ], [
            [sprintf(ConstantNamingConventionsRule::ERROR_MESSAGE_TEMPLATE, 'maxConnections'), 19],
            [sprintf(ConstantNamingConventionsRule::ERROR_MESSAGE_TEMPLATE, 'Default_Timeout'), 21],
            [sprintf(ConstantNamingConventionsRule::ERROR_MESSAGE_TEMPLATE, 'api_version'), 23],
            [sprintf(ConstantNamingConventionsRule::ERROR_MESSAGE_TEMPLATE, 'InternalFlag'), 25],
            [sprintf(ConstantNamingConventionsRule::ERROR_MESSAGE_TEMPLATE, 'bufferSize'), 27],
            [sprintf(ConstantNamingConventionsRule::ERROR_MESSAGE_TEMPLATE, 'MIXED_case'), 29],
            [sprintf(ConstantNamingConventionsRule::ERROR_MESSAGE_TEMPLATE, 'lowercase'), 31],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/configured_rule.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ConstantNamingConventionsRule::class);
    }
}
