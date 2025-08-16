<?php

namespace Orrison\MeliorStan\Tests\Rules\BooleanGetMethodName\Fixture;

class ExampleClass
{
    // These should trigger violations - get methods with boolean return
    public function getBooleanValue(): bool
    {
        return true;
    }

    public function getIsValid(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function getFlag()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function getEnabled()
    {
        return false;
    }

    // These should NOT trigger violations - get methods without boolean return
    public function getString(): string
    {
        return 'hello';
    }

    public function getNumber(): int
    {
        return 42;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'test';
    }

    // These should NOT trigger violations - non-get methods with boolean return
    public function isValid(): bool
    {
        return true;
    }

    public function hasItems(): bool
    {
        return false;
    }

    public function canPerform(): bool
    {
        return true;
    }

    // These have parameters, behavior depends on configuration
    public function getActiveFlag(string $type): bool
    {
        return true;
    }

    public function getValidated(array $data): bool
    {
        return false;
    }

    /**
     * @param mixed $input
     *
     * @return bool
     */
    public function getProcessed($input)
    {
        return true;
    }

    // Edge cases
    public function _getPrivateBoolean(): bool
    {
        return false;
    }

    public function GetCamelCase(): bool // Capital G
    {
        return true;
    }

    // Methods with mixed return types in docblock
    /**
     * @return bool|null
     */
    public function getMaybeBoolean()
    {
        return null;
    }

    // Return type with 'true' or 'false' literals
    public function getTrue(): true
    {
        return true;
    }

    public function getFalse(): false
    {
        return false;
    }
}
