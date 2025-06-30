<?php

namespace Orrison\MessedUpPhpstan\Tests\Rules\CamelCaseMethodName\Fixture;

class ExampleClass
{
    // Valid
    public function doSomething() {}
    public function getHttpResponse() {}
    public function testMethod() {}

    // PHP magic methods (should be ignored by the rule)
    public function __construct() {}
    public function __destruct() {}
    public function __set($name, $value) {}
    public function __get($name) {}
    public function __call($name, $arguments) {}
    public static function __callStatic($name, $arguments) {}
    public function __isset($name) {}
    public function __unset($name) {}
    public function __sleep() {}
    public function __wakeup() {}
    public function __toString() { return ''; }
    public function __invoke() {}
    public static function __set_state($array) {}
    public function __clone() {}
    public function __debugInfo() {}
    public function __serialize(): array { return []; }
    public function __unserialize(array $data): void {}

    // Invalid for default config
    public function do_something_invalid() {}
    public function DoSomethingInvalid() {}
    public function getHTTPResponseInvalid() {}
    public function _prefixedWithUnderscore() {}
    public function test_with_underscores_invalid() {}
    public function getXMLDataInvalid() {}
}
