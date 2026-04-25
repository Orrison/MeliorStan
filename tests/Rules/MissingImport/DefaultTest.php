<?php

namespace Orrison\MeliorStan\Tests\Rules\MissingImport;

use Orrison\MeliorStan\Rules\MissingImport\MissingImportRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<MissingImportRule>
 */
class DefaultTest extends RuleTestCase
{
    public function testExplicitFqcnUsages(): void
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

    public function testGlobalNamespaceClassesAreAlsoFlagged(): void
    {
        $this->analyse(
            [__DIR__ . '/Fixture/GlobalNamespaceUsages.php'],
            [
                [sprintf(MissingImportRule::ERROR_MESSAGE_TEMPLATE, 'stdClass'), 9],
                [sprintf(MissingImportRule::ERROR_MESSAGE_TEMPLATE, 'DateTime'), 10],
                [sprintf(MissingImportRule::ERROR_MESSAGE_TEMPLATE, 'Exception'), 11],
            ]
        );
    }

    public function testImportedUsagesHaveNoViolations(): void
    {
        $this->analyse(
            [__DIR__ . '/Fixture/ImportedUsages.php'],
            []
        );
    }

    public function testEnumFqcnUsages(): void
    {
        $this->analyse(
            [__DIR__ . '/Fixture/EnumUsages.php'],
            [
                [sprintf(MissingImportRule::ERROR_MESSAGE_TEMPLATE, 'App\Contracts\HasLabel'), 5],
                [sprintf(MissingImportRule::ERROR_MESSAGE_TEMPLATE, 'App\Models\User'), 9],
                [sprintf(MissingImportRule::ERROR_MESSAGE_TEMPLATE, 'App\Services\SomeService'), 9],
                [sprintf(MissingImportRule::ERROR_MESSAGE_TEMPLATE, 'App\Models\User'), 11],
            ]
        );
    }

    public function testEnumImportedUsagesHaveNoViolations(): void
    {
        $this->analyse(
            [__DIR__ . '/Fixture/EnumImportedUsages.php'],
            []
        );
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/default.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(MissingImportRule::class);
    }
}
