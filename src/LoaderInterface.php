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
    public function match(\SplFileInfo $file): bool;
    public function parse(\SplFileInfo $file): array;
    public function getSupportedExtensions(): array;
}