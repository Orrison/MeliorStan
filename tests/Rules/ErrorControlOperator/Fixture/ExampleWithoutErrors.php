<?php

namespace Orrison\MeliorStan\Tests\Rules\ErrorControlOperator\Fixture;

use Throwable;

class ExampleWithoutErrors
{
    public function properFileHandling(): void
    {
        $path = '/tmp/file.txt';

        if (file_exists($path)) {
            unlink($path);
        }
    }

    public function properFileOpen(): mixed
    {
        $file = '/tmp/data.csv';

        $handle = fopen($file, 'r');

        if ($handle === false) {
            return null;
        }

        return $handle;
    }

    public function properArrayAccess(): mixed
    {
        $data = ['key' => 'value'];

        return $data['missing'] ?? null;
    }

    public function properExceptionHandling(): void
    {
        try {
            $this->riskyOperation();
        } catch (Throwable $e) {
            // Handle exception properly
        }
    }

    protected function riskyOperation(): void
    {
        // Some operation
    }
}
