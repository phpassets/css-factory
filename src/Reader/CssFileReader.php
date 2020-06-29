<?php

namespace PhpAssets\Css\Factory\Reader;

use PhpAssets\Css\ReaderInterface;

class CssFileReader implements ReaderInterface
{
    /**
     * Get CSS extension language name from path.
     *
     * @param string $path
     * @return string
     */
    public function lang($path)
    {
        return pathinfo($path)['extension'];
    }

    /**
     * Get raw CSS or extension string from path.
     *
     * @param string $path
     * @return string
     */
    public function raw($path)
    {
        return file_get_contents($path);
    }
}
