<?php
/**
 * This file is part of Union.
 * (c) 2016 Union maintainers, All rights reserved.
 *
 * The applied license is stored at the root directory of this package.
 */

namespace Union\Entities;


class CallableEntity
{
    private $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function getCallback()
    {
        return $this->callback;
    }
}