<?php

namespace Orrison\MeliorStan\Rules\DevelopmentCodeFragment;

class Config
{
    public const array DEFAULT_UNWANTED_FUNCTIONS = [
        'var_dump',
        'print_r',
        'debug_zval_dump',
        'debug_print_backtrace',
        'dd',
        'dump',
        'ray',
    ];

    /** @var string[] */
    protected array $unwantedFunctions;

    /**
     * @param string[] $unwantedFunctions
     */
    public function __construct(
        array $unwantedFunctions = [],
    ) {
        $this->unwantedFunctions = $unwantedFunctions === [] ? self::DEFAULT_UNWANTED_FUNCTIONS : $unwantedFunctions;
    }

    /**
     * @return string[]
     */
    public function getUnwantedFunctions(): array
    {
        return $this->unwantedFunctions;
    }
}
