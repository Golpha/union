<?php
/**
 * This file is part of Union.
 * (c) 2016 Union maintainers, All rights reserved.
 *
 * The applied license is stored at the root directory of this package.
 */

namespace Union;


use Union\Entities\CallableEntity;
use Union\Entities\GroupEntity;
use Union\Traits\StorageLayer;

class Configuration implements ConfigurationInterface
{
    use StorageLayer;

    /**
     * sets a key with the given value
     *
     * @param string $key
     * @param $value
     * @return Configuration
     */
    public function set(string $key, $value): Configuration
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * mounts another Configuration-instance as a GroupEntity to this Configuration
     *
     * @param string $key
     * @param Configuration $configuration
     * @return Configuration
     */
    public function mount(string $key, Configuration $configuration): Configuration
    {
        $this->data[$key] = new GroupEntity($configuration->data());

        return $this;
    }

    /**
     * encloses a callback as a CallbackEntity-Instance stored at the given key.
     *
     * @param string $key
     * @param callable $callback
     * @return Configuration
     */
    public function enclose(string $key, callable $callback): Configuration
    {
        $this->data[$key] = new CallableEntity($callback);

        return $this;
    }
}