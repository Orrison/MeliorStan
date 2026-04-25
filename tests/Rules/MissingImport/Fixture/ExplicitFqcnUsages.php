<?php

namespace Orrison\MeliorStan\Tests\Rules\MissingImport\Fixture;

class ExplicitFqcnUsages
{
    private \App\Models\User $property;

    public function newExpression(): void
    {
        $obj = new \App\Services\SomeService();
    }

    public function staticCall(): void
    {
        \App\Services\SomeService::create();
    }

    public function parameterType(\App\Models\User $user): void {}

    public function returnType(): \App\Models\User
    {
        return new \App\Models\User();
    }

    public function instanceofCheck(mixed $value): void
    {
        if ($value instanceof \App\Models\User) {
        }
    }

    public function catchBlock(): void
    {
        try {
        } catch (\App\Exceptions\CustomException $e) {
        }
    }
}
