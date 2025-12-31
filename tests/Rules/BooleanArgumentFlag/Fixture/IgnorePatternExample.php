<?php

namespace Orrison\MeliorStan\Tests\Rules\BooleanArgumentFlag\Fixture;

class IgnorePatternExample
{
    public function setEnabled(bool $enabled) {}

    public function setFlag(bool $flag) {}

    public function setDebugMode(bool $debug) {}

    public function processWithFlag(bool $flag) {}

    public function handleBool(bool $value) {}

    public function isValid(string $name) {}

    public function setName(string $name) {}
}

function setGlobal(bool $value) {}

function processGlobal(bool $value) {}

$setterClosure = fn (bool $value) => $value;

$processorClosure = fn (bool $value) => $value;
