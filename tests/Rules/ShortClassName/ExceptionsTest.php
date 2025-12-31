<?php

namespace Orrison\MeliorStan\Tests\Rules;

use Orrison\MeliorStan\Rules\ShortClassName\ShortClassNameRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ShortClassNameRule>
 */
class ExceptionsTest extends RuleTestCase
{
    public function testRule(): void
    {
        // A.php is in exceptions list, so should have no errors
        $this->analyse([__DIR__ . '/Fixture/A.php'], []);

        // AB.php is not in exceptions list, so should have an error
        $this->analyse([__DIR__ . '/Fixture/AB.php'], [
            [
                'Class name "AB" is too short (2 chars). Minimum allowed length is 3 characters.',
                5,
            ],
        ]);

        // ABC.php meets minimum length of 3, so should have no errors
        $this->analyse([__DIR__ . '/Fixture/ABC.php'], []);
    }

    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/exceptions.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(ShortClassNameRule::class);
    }
}
