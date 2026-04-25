<?php

namespace Orrison\MeliorStan\Tests\Rules\MissingImport\Fixture;

enum EnumUsages: string implements \App\Contracts\HasLabel
{
    case Active = 'active';

    public function label(\App\Services\SomeService $service): \App\Models\User
    {
        return new \App\Models\User();
    }
}
