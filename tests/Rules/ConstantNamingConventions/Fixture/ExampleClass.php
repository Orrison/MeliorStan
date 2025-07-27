<?php

namespace Orrison\MessedUpPhpstan\Tests\Rules\ConstantNamingConventions\Fixture;

class ExampleClass
{
    // Valid constants (all uppercase)
    public const MAX_CONNECTIONS = 100;

    public const DEFAULT_TIMEOUT = 30;

    public const API_VERSION = '1.0';

    private const INTERNAL_FLAG = true;

    protected const BUFFER_SIZE = 1024;

    // Invalid constants (not all uppercase)
    public const maxConnections = 100;

    public const Default_Timeout = 30;

    public const api_version = '1.0';

    public const InternalFlag = true;

    public const bufferSize = 1024;

    public const MIXED_case = 'test';

    public const lowercase = 'test';
}
