<?php

namespace PhpAssets\Css\Factory\Compiler;

use PhpAssets\Css\CompilerInterface;

class CssCompiler implements CompilerInterface
{
    /**
     * Compile raw CSS string.
     *
     * @param string $raw
     * @return string
     */
    public function compile($raw)
    {
        return $raw;
    }
}
