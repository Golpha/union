<?php
/**
 * This file is part of Union.
 * (c) 2016 Union maintainers, All rights reserved.
 *
 * The applied license is stored at the root directory of this package.
 */

ini_set('display_errors', true);
error_reporting(-1);

require __DIR__.'/vendor/autoload.php';

use Union\ConfigurationFactory;
use Union\Loader\JsonLoader;
use Union\Loader\PHPFileLoader;

$factory = new ConfigurationFactory();
$factory->register(JsonLoader::class, PHPFileLoader::class);

$config = $factory->load(new SplFileInfo(__DIR__.'/config'));

var_dump($config->get('a'));