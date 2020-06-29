<?php

namespace PhpAssets\Css\Factory;

use PhpAssets\Css\ReaderInterface;
use PhpAssets\Css\MinifierInterface;
use PhpAssets\Minify\CssMinifierInterface;
use PhpAssets\Css\Factory\Reader\ReaderResolver;
use PhpAssets\Css\Factory\Compiler\CompilerResolver;

class Factory
{
    /**
     * Compiler resolver instance.
     * 
     * @var \PhpAssets\Css\Factory\Compiler\CompilerResolver
     */
    protected $compilerResolver;

    /**
     * File interpreter resolver instance.
     *
     * @var \PhpAssets\Css\Factory\Reader\ReaderResolver
     */
    protected $readerResolver;

    /**
     * Default minifier instance.
     *
     * @var \PhpAssets\Minify\MinifierInterface
     */
    protected $minifier;

    /**
     * Create new Factory instance.
     *
     * @param CompilerResolver $compilerResolver
     * @param ReaderResolver $readerResolver
     * @param CssMinifierInterface $minifier
     */
    public function __construct(
        CompilerResolver $compilerResolver,
        ReaderResolver $readerResolver,
        MinifierInterface $minifier = null
    ) {
        $this->compilerResolver = $compilerResolver;
        $this->readerResolver = $readerResolver;
        $this->minifier = $minifier;
    }

    /**
     * Create new Style instance from path.
     *
     * @param string $path
     * @param MinifierInterface $minifier
     * @return \PhpAssets\Css\Factory\Style
     */
    public function make(string $path, MinifierInterface $minifier = null)
    {
        $reader = $this->readerResolver->resolve($path);

        $lang = $this->getLang($path, $reader);

        $compiler = $this->compilerResolver->resolve($lang);

        $minifier = $minifier === null ? $this->minifier : $minifier;

        return new Style($path, $lang, $compiler, $reader, $this->minifier);
    }

    /**
     * Get CSS extension language name from path.
     *
     * @param string $path
     * @param \PhpAssets\Css\ReaderInterface $reader
     * @return string
     */
    public function getLang($path, ReaderInterface $reader)
    {
        return $reader->lang($path);
    }
}
