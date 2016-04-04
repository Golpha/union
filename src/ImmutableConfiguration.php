<?php
/**
 * This file is part of Union.
 * (c) 2016 Union maintainers, All rights reserved.
 *
 * The applied license is stored at the root directory of this package.
 */

namespace Union;


use Union\Traits\StorageLayer;

class ImmutableConfiguration implements ConfigurationInterface
{
    use StorageLayer;
}