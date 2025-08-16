<?php

namespace Orrison\MeliorStan\Tests\Rules\Superglobals\Fixture;

class ExampleClass
{
    public function exampleMethod()
    {
        // These should trigger violations - using superglobals
        $serverData = $_SERVER['HTTP_HOST'];
        $getData = $_GET['param'];
        $postData = $_POST['data'];
        $fileData = $_FILES['upload'];
        $cookieData = $_COOKIE['session_id'];
        $sessionData = $_SESSION['user_id'];
        $requestData = $_REQUEST['value'];
        $envData = $_ENV['PATH'];
        $globalData = $GLOBALS['myVar'];

        // These should NOT trigger violations - regular variables
        $myVar = 'hello';
        $camelCase = true;
        $snake_case = false;

        // Dynamic variables should not cause issues
        $varName = 'test';
        $$varName = 'dynamic';
    }

    public function anotherMethod()
    {
        // More superglobal usage that should be detected
        if (isset($_GET['action'])) {
            return $_POST['data'] ?? null;
        }

        foreach ($_COOKIE as $name => $value) {
            echo $name . ': ' . $value;
        }
    }
}
