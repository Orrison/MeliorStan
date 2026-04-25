<?php

namespace Orrison\MeliorStan\Tests\Rules\MissingImport;

use Orrison\MeliorStan\Rules\MissingImport\MissingImportRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<MissingImportRule>
 */
class ExceptionsTest extends RuleTestCase
{
    public function testExceptedClassIsAllowed(): void
    {
        $this->analyse(
            [__DIR__ . '/Fixture/ExceptionsFqcnUsages.php'],
            [
                [sprintf(MissingImportRule::ERROR_MESSAGE_TEMPLATE, 'App\Models\User'), 14],
            ]
        );
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/exceptions.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(MissingImportRule::class);
    }
}
