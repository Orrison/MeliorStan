<?php

namespace Orrison\MeliorStan\Tests\Rules\MissingImport;

use Orrison\MeliorStan\Rules\MissingImport\MissingImportRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<MissingImportRule>
 */
class IgnoreGlobalTest extends RuleTestCase
{
    public function testGlobalNamespaceClassesAreIgnored(): void
    {
        $this->analyse(
            [__DIR__ . '/Fixture/GlobalNamespaceUsages.php'],
            []
        );
    }

    public function testNonGlobalClassesAreStillFlagged(): void
    {
        $this->analyse(
            [__DIR__ . '/Fixture/ExplicitFqcnUsages.php'],
            [
                [sprintf(MissingImportRule::ERROR_MESSAGE_TEMPLATE, 'App\Models\User'), 7],
                [sprintf(MissingImportRule::ERROR_MESSAGE_TEMPLATE, 'App\Services\SomeService'), 11],
                [sprintf(MissingImportRule::ERROR_MESSAGE_TEMPLATE, 'App\Services\SomeService'), 16],
                [sprintf(MissingImportRule::ERROR_MESSAGE_TEMPLATE, 'App\Models\User'), 19],
                [sprintf(MissingImportRule::ERROR_MESSAGE_TEMPLATE, 'App\Models\User'), 21],
                [sprintf(MissingImportRule::ERROR_MESSAGE_TEMPLATE, 'App\Models\User'), 23],
                [sprintf(MissingImportRule::ERROR_MESSAGE_TEMPLATE, 'App\Models\User'), 28],
                [sprintf(MissingImportRule::ERROR_MESSAGE_TEMPLATE, 'App\Exceptions\CustomException'), 35],
            ]
        );
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/ignore_global.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(MissingImportRule::class);
    }
}
