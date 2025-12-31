<?php

namespace Orrison\MeliorStan\Tests\Rules\TooManyMethods\Fixture;

/**
 * This class has 30 total methods:
 * - 10 getters - ignored by default pattern
 * - 5 setters - ignored by default pattern
 * - 5 is* methods - ignored by default pattern
 * - 10 other methods - counted
 *
 * With default ignore pattern ^(get|set|is): 10 methods counted (passes)
 * Without ignore pattern: 30 methods counted (fails with default max 25)
 */
class ClassWithManyMethods
{
    public function getName(): string
    {
        return '';
    }

    public function getAge(): int
    {
        return 0;
    }

    public function getEmail(): string
    {
        return '';
    }

    public function getPhone(): string
    {
        return '';
    }

    public function getAddress(): string
    {
        return '';
    }

    public function getCity(): string
    {
        return '';
    }

    public function getCountry(): string
    {
        return '';
    }

    public function getZipCode(): string
    {
        return '';
    }

    public function getState(): string
    {
        return '';
    }

    public function getFullName(): string
    {
        return '';
    }

    public function setName(string $name): void {}

    public function setAge(int $age): void {}

    public function setEmail(string $email): void {}

    public function setPhone(string $phone): void {}

    public function setAddress(string $address): void {}

    public function isActive(): bool
    {
        return true;
    }

    public function isValid(): bool
    {
        return true;
    }

    public function isEnabled(): bool
    {
        return true;
    }

    public function isVisible(): bool
    {
        return true;
    }

    public function isDeleted(): bool
    {
        return false;
    }

    public function doSomething(): void {}

    public function process(): void {}

    public function handle(): void {}

    public function execute(): void {}

    public function run(): void {}

    public function validate(): void {}

    public function transform(): void {}

    public function convert(): void {}

    public function parse(): void {}

    public function format(): void {}
}
