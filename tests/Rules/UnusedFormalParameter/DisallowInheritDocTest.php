<?php

namespace Orrison\MeliorStan\Tests\Rules\UnusedFormalParameter;

use Orrison\MeliorStan\Rules\UnusedFormalParameter\UnusedFormalParameterRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<UnusedFormalParameterRule>
 */
class DisallowInheritDocTest extends RuleTestCase
{
    public function testInheritDocReported(): void
    {
        // Disable overriding allowance via the inheritdoc-only config so the
        // override skip does not mask the inheritdoc behavior under test.
        $this->analyse(
            [
                __DIR__ . '/Fixture/InheritDocParent.php',
                __DIR__ . '/Fixture/InheritDocChild.php',
            ],
            [
                [sprintf(UnusedFormalParameterRule::ERROR_MESSAGE_TEMPLATE, 'name'), 10],
            ],
        );
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/config/disallow_inheritdoc.neon'];
    }

    protected function getRule(): Rule
    {
        return self::getContainer()->getByType(UnusedFormalParameterRule::class);
    }
}
