<?php

namespace Orrison\MeliorStan\Tests\Rules\PascalCaseClassName;

use Orrison\MeliorStan\Rules\PascalCaseClassName\PascalCaseClassNameRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<PascalCaseClassNameRule>
 */
class PascalCaseClassNameRuleTest extends RuleTestCase
{
    public function testRule(): void
    {
        $this->analyse([__DIR__ . '/Fixture/camelCaseClass.php'], [
            [
                sprintf(PascalCaseClassNameRule::ERROR_MESSAGE_TEMPLATE, 'camelCaseClass'),
                5,
            ],
        ]);

        $this->analyse([__DIR__ . '/Fixture/HTTPResponse.php'], [
            [
                sprintf(PascalCaseClassNameRule::ERROR_MESSAGE_TEMPLATE, 'HTTPResponse'),
                5,
            ],
        ]);

        $this->analyse([__DIR__ . '/Fixture/HttpResponses.php'], []);
    }

    /**
     * @return string[]
     */
    // #[Override]
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/configured_rule.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(PascalCaseClassNameRule::class);
    }
}
