<?php

namespace Orrison\MessedUpPhpstan\Tests\Rules;

use Orrison\MessedUpPhpstan\Rules\LongClassName\LongClassNameRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<LongClassNameRule>
 */
class LongClassNamePrefixesSuffixesTest extends RuleTestCase
{
    public function testWithPrefixesAndSuffixes(): void
    {
        $this->analyse([__DIR__ . '/Fixture/WithPrefixesSuffixes.php'], [
            [
                'Class name "VeryLongClassNameHere" exceeds maximum length of 20 characters (effective length: 21).',
                16,
            ],
        ]);
    }

    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/with_prefixes_suffixes.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(LongClassNameRule::class);
    }
}