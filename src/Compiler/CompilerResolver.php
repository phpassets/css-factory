<?php

namespace PhpAssets\Css\Factory\Compiler;

use Closure;
use InvalidArgumentException;

class CompilerResolver
{
    /**
     * The array of compiler resolvers.
     *
     * @var array
     */
    protected $resolvers = [];

    /**
     * The resolved engine instances.
     *
     * @var array
     */
    protected $resolved = [];

    /**
     * Register a new compiler resolver by CSS extension language name.
     *
     * @param  string  $extension
     * @param  \Closure  $resolver
     * @return void
     */
    public function register($lang, Closure $resolver)
    {
        unset($this->resolved[$lang]);

        $this->resolvers[$lang] = $resolver;
    }

    /**
     * Resolve an compiler instance by CSS extension language name.
     *
     * @param  string  $lang
     * @return \PhpAssets\Css\CompilerInterface
     *
     * @throws \InvalidArgumentException
     */
    public function resolve($lang)
    {
        if (isset($this->resolved[$lang])) {
            return $this->resolved[$lang];
        }

        if (isset($this->resolvers[$lang])) {
            return $this->resolved[$lang] = call_user_func($this->resolvers[$lang]);
        }

        throw new InvalidArgumentException("Compiler CSS extension language [{$lang}] not found.");
    }
}
