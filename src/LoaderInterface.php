<?php
/**
 * This file is part of Union.
 * (c) 2016 Union maintainers, All rights reserved.
 *
 * The applied license is stored at the root directory of this package.
 */

namespace Union;


interface LoaderInterface
{
    /**
     * checks if the file is suitable for the loader
     *
     * @param \SplFileInfo $file
     * @return bool
     */
    public function match(\SplFileInfo $file): bool;

    /**
     * parses the file and returns the content as an array
     *
     * @param \SplFileInfo $file
     * @return array
     */
    public function parse(\SplFileInfo $file): array;

    /**
     * returns the supported file extensions by this loader
     *
     * @return array
     */
    public function getSupportedExtensions(): array;
}