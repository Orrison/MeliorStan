<?php

namespace Orrison\MessedUpPhpstan\Tests\Rules\CamelCaseMethodName\Fixture;

class InvalidCamelCase {
    public function do_something() {}
    public function DoSomething() {}
    public function getHTTPResponse() {}
    public function _privateMethod() {}
}
