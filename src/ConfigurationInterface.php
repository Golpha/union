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
    /**
     * gets the value for a key of the configuration, resolves automatically GroupEntity-instances to arrays and
     * executes CallbackEntity-instances. If no value was found or null the $default will be returned.
     *
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function get(string $key, $default = null);
    public function has(string $key): bool;
    public function isGroup(string $key): bool;
    public function find(string $keyPattern): array;
}