<?php

namespace Orrison\MeliorStan\Tests\Rules\DevelopmentCodeFragment;

use Orrison\MeliorStan\Rules\DevelopmentCodeFragment\DevelopmentCodeFragmentRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<DevelopmentCodeFragmentRule>
 */
class DefaultOptionsTest extends RuleTestCase
{
    public function testRule(): void
    {
        $this->analyse([__DIR__ . '/Fixture/ExampleClass.php'], [
            [sprintf(DevelopmentCodeFragmentRule::ERROR_MESSAGE_TEMPLATE, 'var_dump'), 10],
            [sprintf(DevelopmentCodeFragmentRule::ERROR_MESSAGE_TEMPLATE, 'print_r'), 16],
            [sprintf(DevelopmentCodeFragmentRule::ERROR_MESSAGE_TEMPLATE, 'debug_zval_dump'), 22],
            [sprintf(DevelopmentCodeFragmentRule::ERROR_MESSAGE_TEMPLATE, 'debug_print_backtrace'), 27],
            [sprintf(DevelopmentCodeFragmentRule::ERROR_MESSAGE_TEMPLATE, 'dd'), 33],
            [sprintf(DevelopmentCodeFragmentRule::ERROR_MESSAGE_TEMPLATE, 'dump'), 39],
            [sprintf(DevelopmentCodeFragmentRule::ERROR_MESSAGE_TEMPLATE, 'ray'), 45],
        ]);
    }

    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/default.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(DevelopmentCodeFragmentRule::class);
    }
}
