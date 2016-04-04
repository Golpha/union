<?php
/**
 * This file is part of Union.
 * (c) 2016 Union maintainers, All rights reserved.
 *
 * The applied license is stored at the root directory of this package.
 */

namespace Union;


interface ConfigurationInterface
{
    public function get(string $key, $default = null);
    public function has(string $key): bool;
    public function isGroup(string $key): bool;
    public function find(string $keyPattern): array;
}