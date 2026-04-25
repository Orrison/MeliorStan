<?php

namespace Orrison\MeliorStan\Tests\Rules\MissingImport\Fixture;

use App\Exceptions\CustomException;
use App\Models\User;
use App\Services\SomeService;
use Exception;
use stdClass;

class ImportedUsages
{
    private User $property;

    public function newExpression(): void
    {
        $obj = new SomeService();
        $std = new stdClass();
        $e = new Exception('error');
    }

    public function staticCall(): void
    {
        SomeService::create();
    }

    public function parameterType(User $user): void {}

    public function returnType(): User
    {
        return new User();
    }

    public function instanceofCheck(mixed $value): void
    {
        if ($value instanceof User) {
        }
    }

    public function catchBlock(): void
    {
        try {
        } catch (CustomException $e) {
        }
    }
}
