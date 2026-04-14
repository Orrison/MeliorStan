<?php

namespace Orrison\MeliorStan\Tests\Rules\DevelopmentCodeFragment;

use Orrison\MeliorStan\Rules\DevelopmentCodeFragment\DevelopmentCodeFragmentRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<DevelopmentCodeFragmentRule>
 */
class CustomFunctionsTest extends RuleTestCase
{
    public function testRule(): void
    {
        $this->analyse([__DIR__ . '/Fixture/CustomFunctionsFixture.php'], [
            [sprintf(DevelopmentCodeFragmentRule::ERROR_MESSAGE_TEMPLATE, 'dump'), 10],
            [sprintf(DevelopmentCodeFragmentRule::ERROR_MESSAGE_TEMPLATE, 'dd'), 16],
            [sprintf(DevelopmentCodeFragmentRule::ERROR_MESSAGE_TEMPLATE, 'my_custom_debug'), 22],
        ]);
    }

    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/custom_functions.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(DevelopmentCodeFragmentRule::class);
    }
}
