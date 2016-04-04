<?php
/**
 * This file is part of Union.
 * (c) 2016 Union maintainers, All rights reserved.
 *
 * The applied license is stored at the root directory of this package.
 */

namespace Union\Traits;


use Union\Entities\CallableEntity;
use Union\Entities\GroupEntity;

trait StorageLayer
{
    /**
     * @var array|GroupEntity[]|CallableEntity[]
     */
    private $data = [];

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function get(string $key, $default = null)
    {
        if ( $this->isGroup($key) ) {
            return $this->data[$key]->toArray();
        }

        if ( $this->has($key) && $this->data[$key] instanceof CallableEntity )
        {
            return call_user_func($this->data[$key]->getCallback());
        }

        return $this->data[$key] ?? $default;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    public function isGroup(string $key): bool
    {
        return $this->has($key) && $this->data[$key] instanceof GroupEntity;
    }

    public function find(string $keyPattern): array
    {
        return array_filter($this->data, function($key) use ($keyPattern) {
            return 0 === stripos($key, $keyPattern);
        }, ARRAY_FILTER_USE_KEY);
    }

    protected function data()
    {
        return $this->data;
    }
}