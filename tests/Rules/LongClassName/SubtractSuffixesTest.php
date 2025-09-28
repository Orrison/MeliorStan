<?php

namespace Orrison\MeliorStan\Tests\Rules;

use Orrison\MeliorStan\Rules\LongClassName\LongClassNameRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<LongClassNameRule>
 */
class SubtractSuffixesTest extends RuleTestCase
{
    public function testRule(): void
    {
        $this->analyse([__DIR__ . '/Fixture/SubtractSuffixesClass.php'], []);
    }

    /**
     * @return string[]
     */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/subtract_suffixes.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(LongClassNameRule::class);
    }
}
