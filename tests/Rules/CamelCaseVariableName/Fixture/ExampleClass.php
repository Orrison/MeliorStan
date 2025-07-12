<?php

namespace Orrison\MessedUpPhpstan\Tests\Rules\CamelCaseVariableName\Fixture;

class ExampleClass
{
    public function exampleMethod()
    {
        $isHttpResponse = true;

        $is_http_response = false;

        $IsHttpResponse = true;

        $isHTTPResponse = false;

        $IsHTTPResponse = true;

        $ISHTTPRESPONSE = false;

        $_isHttpResponse = true;

        $_isHTTPResponse = false;

        // PHP superglobals should be ignored
        $value = $_SERVER['HTTP_HOST'] ?? null;
        $data = $_POST['data'] ?? null;
        $cookies = $_COOKIE;

        // Special PHP variables should be ignored
        if (isset($php_errormsg)) {
            $error = $php_errormsg;
        }

        if (isset($http_response_header)) {
            $headers = $http_response_header;
        }
    }
}
