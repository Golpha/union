<?php
/**
 * This file is part of Union.
 * (c) 2016 Union maintainers, All rights reserved.
 *
 * The applied license is stored at the root directory of this package.
 */

namespace Union\Entities;


use Union\ConfigurationInterface;
use Union\Traits\StorageLayer;

class GroupEntity implements ConfigurationInterface
{
    use StorageLayer;

    public function toArray()
    {
        return array_combine(
            array_keys($this->data),
            array_map(function($value, $key) {
            return $this->isGroup($key) ? $value->toArray() : $value;
            }, $this->data, array_keys($this->data))
        );
    }
}