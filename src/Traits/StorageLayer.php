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

    /**
     * StorageLayer constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * gets the value for a given key. if the key does not exists, $default would be returned. If the given key
     * is known and a GroupEntity-instance, the GroupEntity-instance will be resolved as an array. If the given key
     * is known and a CallableEntity, the callback will be executed.
     *
     * @param string $key
     * @param null $default
     * @return mixed
     */
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

    /**
     * Checks whether the given key does exists or not.
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * checks whether the value of a key in the storage is a GroupEntity-instance or not.
     *
     * @param string $key
     * @return bool
     */
    public function isGroup(string $key): bool
    {
        return $this->has($key) && $this->data[$key] instanceof GroupEntity;
    }

    /**
     * does a case-insensitive lookup for keys that starts with the keyPattern. No grep-like or regex-like matching
     * just plain strings.
     *
     * @param string $keyPattern
     * @return array
     */
    public function find(string $keyPattern): array
    {
        return array_filter($this->data, function($key) use ($keyPattern) {
            return 0 === stripos($key, $keyPattern);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * internally used.
     *
     * @return array|\Union\Entities\CallableEntity[]|\Union\Entities\GroupEntity[]
     */
    protected function data()
    {
        return $this->data;
    }
}