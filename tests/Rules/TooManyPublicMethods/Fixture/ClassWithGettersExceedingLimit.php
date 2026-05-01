<?php

namespace Orrison\MeliorStan\Tests\Rules\TooManyPublicMethods\Fixture;

// 11 public methods including getters, exceeds limit when ignore_pattern is empty
class ClassWithGettersExceedingLimit
{
    public function getName(): string
    {
        return '';
    }

    public function getEmail(): string
    {
        return '';
    }

    public function getAge(): int
    {
        return 0;
    }

    public function getAddress(): string
    {
        return '';
    }

    public function getPhone(): string
    {
        return '';
    }

    public function setName(string $name): void {}

    public function setEmail(string $email): void {}

    public function setAge(int $age): void {}

    public function isActive(): bool
    {
        return true;
    }

    public function isVerified(): bool
    {
        return false;
    }

    public function process(): void {}
}
