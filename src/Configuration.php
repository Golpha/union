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

    public function set(string $key, $value): Configuration
    {
        $this->data[$key] = $value;

        return $this;
    }

    public function mount(string $key, Configuration $configuration): Configuration
    {
        $this->data[$key] = new GroupEntity($configuration->data());

        return $this;
    }

    public function enclose(string $key, callable $callback): Configuration
    {
        $this->data[$key] = new CallableEntity($callback);

        return $this;
    }
}