<?php

namespace Orrison\MeliorStan\Tests\Rules\EmptyCatchBlock\Fixture;

use Exception;
use RuntimeException;

class ExampleClass
{
    public function methodWithEmptyCatch(): void
    {
        try {
            $this->riskyOperation();
        } catch (Exception $e) {
            // Empty catch block
        }
    }

    public function methodWithEmptyCatchNoComment(): void
    {
        try {
            $this->riskyOperation();
        } catch (RuntimeException $e) {
        }
    }

    public function methodWithMultipleEmptyCatches(): void
    {
        try {
            $this->riskyOperation();
        } catch (RuntimeException $e) {
        } catch (Exception $e) {
        }
    }

    public function methodWithValidCatch(): void
    {
        try {
            $this->riskyOperation();
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    public function methodWithValidCatchRethrow(): void
    {
        try {
            $this->riskyOperation();
        } catch (Exception $e) {
            throw new RuntimeException('Operation failed', 0, $e);
        }
    }

    public function methodWithValidCatchReturn(): void
    {
        try {
            $this->riskyOperation();
        } catch (Exception $e) {
            return;
        }
    }

    public function methodWithOnlyComment(): void
    {
        try {
            $this->riskyOperation();
        } catch (Exception $e) {
            // Just a comment, still empty
        }
    }

    private function riskyOperation(): void
    {
        // Some risky code
    }
}
