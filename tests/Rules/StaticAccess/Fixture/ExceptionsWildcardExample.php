<?php

namespace Orrison\MeliorStan\Tests\Rules\StaticAccess\Fixture;

use Orrison\MeliorStan\Tests\Rules\StaticAccess\Fixture\Helpers\ArrayHelper;
use Orrison\MeliorStan\Tests\Rules\StaticAccess\Fixture\Helpers\StringHelper;

class ExceptionsWildcardExample
{
    public function test(): void
    {
        StringHelper::trim('hello');
        ArrayHelper::flatten([]);
        SomeService::process();
    }
}
