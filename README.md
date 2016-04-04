# UNION
Explary ( not yet documented or deeply tested ) Configuration Implementation

```json
{
  "autoload": {
    "psr-4": {
      "Union\\":"../src"
    }
  }
}
```

```php
<?php

ini_set('display_errors', true);
error_reporting(-1);

require __DIR__.'/vendor/autoload.php';

use Union\ConfigurationFactory;
use Union\Loader\JsonLoader;
use Union\Loader\PHPFileLoader;

$factory = new ConfigurationFactory();
$factory->register(JsonLoader::class, PHPFileLoader::class);

$config = $factory->load(new SplFileInfo(__DIR__.'/config')); // a entire directory

// or

$config = $factory->load(new SplFileInfo(__DIR__.'/config/foobar.json')); // a file

```