<?php
/**
 * This file is part of Union.
 * (c) 2016 Union maintainers, All rights reserved.
 *
 * The applied license is stored at the root directory of this package.
 */

namespace Union\Loader;


use Union\LoaderInterface;

class PHPFileLoader implements LoaderInterface
{
    /**
     * checks if the file is suitable for the loader
     *
     * @param \SplFileInfo $file
     * @return bool
     */
    public function match(\SplFileInfo $file): bool
    {
        return in_array(strtolower($file->getExtension()), $this->getSupportedExtensions());
    }

    /**
     * parses the file and returns the content as an array
     *
     * @param \SplFileInfo $file
     * @return array
     */
    public function parse(\SplFileInfo $file): array
    {
        return include $file->getRealPath();
    }

    /**
     * returns the supported file extensions by this loader
     *
     * @return array
     */
    public function getSupportedExtensions(): array
    {
        return [
            'php',
            'php5',
            'inc'
        ];
    }

}