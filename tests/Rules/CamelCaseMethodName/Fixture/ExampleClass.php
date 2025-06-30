<?php

namespace Orrison\MessedUpPhpstan\Tests\Rules\CamelCaseMethodName\Fixture;

class ExampleClass
{
    // Valid
    public function doSomething() {}
    public function getHttpResponse() {}
    public function testMethod() {}

    // Invalid for default config
    public function do_something_invalid() {}
    public function DoSomethingInvalid() {}
    public function getHTTPResponseInvalid() {}
    public function _prefixedWithUnderscore() {}
    public function test_with_underscores_invalid() {}
    public function getXMLDataInvalid() {}
}
