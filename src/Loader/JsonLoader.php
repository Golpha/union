<?php
/**
 * This file is part of Union.
 * (c) 2016 Union maintainers, All rights reserved.
 *
 * The applied license is stored at the root directory of this package.
 */

namespace Union\Loader;


use Union\LoaderInterface;

class JsonLoader implements LoaderInterface
{
    public function match(\SplFileInfo $file): bool
    {
        return in_array(strtolower($file->getExtension()), $this->getSupportedExtensions());
    }

    public function parse(\SplFileInfo $file): array
    {
        return json_decode(file_get_contents($file->getRealPath()), true);
    }

    public function getSupportedExtensions(): array
    {
        return [
            'json'
        ];
    }
}