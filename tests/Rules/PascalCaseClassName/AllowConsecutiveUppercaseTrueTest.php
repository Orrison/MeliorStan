<?php

namespace Orrison\MessStan\Tests\Rules;

use Orrison\MessStan\Rules\PascalCaseClassName\PascalCaseClassNameRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<PascalCaseClassNameRule>
 */
class AllowConsecutiveUppercaseTrueTest extends RuleTestCase
{
    public function testRule(): void
    {
        $this->analyse([__DIR__ . '/Fixture/camelCaseClass.php'], [
            [
                'Class name "camelCaseClass" is not in PascalCase.',
                5,
            ],
        ]);

        $this->analyse([__DIR__ . '/Fixture/HTTPResponse.php'], []);

        $this->analyse([__DIR__ . '/Fixture/HttpResponses.php'], []);
    }

    /**
     * @return string[]
     */
    // #[Override]
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/allow_consecutive_uppercase_true.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(PascalCaseClassNameRule::class);
    }
}
