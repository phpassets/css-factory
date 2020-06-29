<?php

namespace PhpAssets\Css\Factory;

use PhpAssets\Css\ReaderInterface;
use PhpAssets\Css\CompilerInterface;
use PhpAssets\Css\MinifierInterface;
use PhpAssets\Minify\CssMinifierInterface;

class Style
{
    /**
     * Path where style is located.
     *
     * @var string
     */
    protected $path;

    /**
     * CSS extension language name.
     *
     * @var string
     */
    protected $lang;

    /**
     * Compiler instance.
     *
     * @var \PhpAssets\Css\CompilerInterface
     */
    protected $compiler;

    /**
     * File interpreter instance.
     *
     * @var \PhpAssets\Css\ReaderInterface
     */
    protected $reader;

    /**
     * Minifier instance.
     *
     * @var \PhpAssets\Minify\MinifierInterface
     */
    protected $minifier;

    /**
     * Raw CSS or extension string.
     *
     * @var string
     */
    protected $raw;

    /**
     * Has raw been loaded.
     *
     * @var boolean
     */
    protected $rawLoaded = false;

    /**
     * Compiled (and minfied) CSS string.
     *
     * @var string
     */
    protected $compiled;

    /**
     * Has style been compiled before.
     *
     * @var boolean
     */
    protected $compilerExecuted = false;

    /**
     * Create new Style instance.
     *
     * @param string $raw
     * @param CompilerInterface $compiler
     * @param CssMinifierInterface $minifier
     */
    public function __construct($path, $lang, CompilerInterface $compiler, ReaderInterface $reader, MinifierInterface $minifier = null)
    {
        $this->path = $path;
        $this->lang = $lang;
        $this->compiler = $compiler;
        $this->reader = $reader;
        $this->minifier = $minifier;
    }

    /**
     * Compile raw CSS or extension string.
     *
     * @param boolean $minify
     * @return string
     */
    public function compile($minify = true)
    {
        $this->loadRaw();

        $compiled = $this->compiler->compile($this->raw);

        if ($minify && $this->minifier) {
            $compiled = $this->minifier->minify($compiled);
        }

        $this->compiled = $compiled;

        $this->compilerExecuted = true;

        return $compiled;
    }

    /**
     * Load raw CSS or extension string.
     *
     * @return void
     */
    public function loadRaw()
    {
        $this->raw = $this->reader->raw($this->path);
        $this->rawLoaded = true;
    }

    /**
     * Get compiled string. Return from cache when CSS has already been compiled.
     *
     * @param boolean $minify
     * @return string
     */
    public function getCompiled($minify = true)
    {
        // TODO: set compiled loaded
        if (!$this->compiled) {
            return $this->compile($minify);
        }

        return $this->compiled;
    }

    /**
     * Get raw CSS or extension string.
     *
     * @return string
     */
    public function getRaw($force = false)
    {
        if (!$this->isRawLoaded() || $force) {
            $this->loadRaw();
        }

        return $this->raw;
    }

    /**
     * Get reader instance.
     *
     * @return string
     */
    public function getReader()
    {
        return $this->reader;
    }

    /**
     * Get compiler instance.
     *
     * @return \PhpAssets\Css\CompilerInterface
     */
    public function getCompiler()
    {
        return $this->compiler;
    }

    /**
     * Get path where style is located.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * CSS extension language name.
     *
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * Determines wheter style has been compiled.
     *
     * @return boolean
     */
    public function isCompiled()
    {
        return $this->compilerExecuted;
    }

    /**
     * Determines wheter raw has been laoded.
     *
     * @return boolean
     */
    public function isRawLoaded()
    {
        return $this->rawLoaded;
    }
}
