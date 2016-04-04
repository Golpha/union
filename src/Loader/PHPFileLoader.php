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
    public function match(\SplFileInfo $file): bool
    {
        return in_array(strtolower($file->getExtension()), $this->getSupportedExtensions());
    }

    public function parse(\SplFileInfo $file): array
    {
        return include $file->getRealPath();
    }

    public function getSupportedExtensions(): array
    {
        return [
            'php',
            'php5',
            'inc'
        ];
    }

}