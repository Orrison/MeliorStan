<?php

namespace Orrison\MeliorStan\Tests\Rules\CognitiveComplexity\Fixture;

use LogicException;
use RuntimeException;

class TryCatchFinallyClass
{
    public function run(int $x, int $y, int $z): void
    {
        try {
            if ($x > 0) {
                throw new RuntimeException();
            }
        } catch (RuntimeException $e) {
            // empty
        } catch (LogicException $e) {
            if ($y > 0) {
                $this->handle();
            }
        } finally {
            if ($z > 0) {
                $this->log();
            }
        }
    }

    protected function handle(): void {}

    protected function log(): void {}
}
