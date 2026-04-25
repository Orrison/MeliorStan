<?php

namespace Orrison\MeliorStan\Tests\Rules\TooManyFields;

use Orrison\MeliorStan\Rules\TooManyFields\TooManyFieldsRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<TooManyFieldsRule>
 */
class IncludeStaticPropertiesTest extends RuleTestCase
{
    public function testRule(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixture/ClassWithStaticFields.php',
            ],
            [
                [
                    sprintf(TooManyFieldsRule::ERROR_MESSAGE_TEMPLATE, 'Class', 'ClassWithStaticFields', 17, 15),
                    8,
                ],
            ]
        );
    }

    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/include_static_properties.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(TooManyFieldsRule::class);
    }
}
