DTail
================

Watch and search Logs entries stored in a DynamoDB table

[![Total Downloads](https://poser.pugx.org/otternq/DTail/downloads.png)](https://packagist.org/packages/otternq/DTail)
[![Latest Stable Version](https://poser.pugx.org/otternq/DTail/v/stable.png)](https://packagist.org/packages/otternq/DTail)


| Master | Development |
| ------ | ----------- |
| [![Build Status](https://travis-ci.org/otternq/DTail.png?branch=master)](https://travis-ci.org/otternq/DTail) | [![Build Status](https://travis-ci.org/otternq/DTail.png?branch=development)](https://travis-ci.org/otternq/DTail) |
| [![Coverage Status](https://coveralls.io/repos/otternq/DTail/badge.png?branch=master)](https://coveralls.io/r/otternq/DTail?branch=master) | [![Coverage Status](https://coveralls.io/repos/otternq/DTail/badge.png?branch=development)](https://coveralls.io/r/otternq/DTail?branch=development) |

Installing
-------

DTail is available on [Packagist](https://packagist.org/packages/otternq/dtail).

To install with composer, add: `"otternq/dtail": "dev-master"` to _composer.json_ in the **require** section:

```json
"require": {
    "php": ">=5.3.3",
    "otternq/dtail": "dev-master"
}
```

then run `php composer.phar update` (or `php composer.phar install` depending on the situation) and let composer do the rest.

Usage
-------

If you want to incoorperate this into another system, see **Usage 1**. If you just want to see the log entries, see **Usage 2**

###Usage 1

```php
include "vendor/autoload.php";

use Colors\Color;

use Aws\Common\Aws;
use Aws\DynamoDb\DynamoDbClient;

use DTail\DTail;

$config = array(
    'dyn-table' => 'PHPErrors',
    'dyn-key'    => YOUR_AWS_KEY,
    'dyn-secret' => YOUR_AWS_SECRET,
    'dyn-region' => 'us-east-1'
);

$dynamodbClient = DynamoDbClient::factory(array(
    'key'    => $config['dyn-key'],
    'secret' => $config['dyn-secret'],
    'region' => $config['dyn-region'],
    )
);

$dtail = new DTail($dynamodbClient);

$iterator = $dtail->get(
    $config['dyn-table'], 
    'PHPErrorReporter'
);

foreach($iterator as $item) {
    var_dump($item);
}

```

###Usage 2

If you just want to watch/search log files then use the `bin/dtail` command:

```bash
bin/dtail -f /path/to/config/file.php
```

the config file will look like:

```php
return array(
    'dyn-table' => 'PHPErrors',
    'dyn-key'    => YOUR_AWS_KEY,
    'dyn-secret' => YOUR_AWS_SECRET,
    'dyn-region' => 'us-east-1'
);
```

and the output will look like:

```
Channel           Date Time   Level      Message                                                      Context
PHPErrorReporter  2013-11-14  WARNING    Test                                                         []
PHPErrorReporter  2013-11-14  WARNING    E_WARNING: Division by zero                                  {"file":"/path/to/DTail/app.php","line":26}
PHPErrorReporter  2013-11-14  NOTICE     E_NOTICE: Undefined variable: foo                            {"file":"/path/to/DTail/error.php","line":27}
PHPErrorReporter  2013-11-14  WARNING    E_WARNING: Division by zero                                  {"file":"/path/to/DTail/error.php","line":28}
PHPErrorReporter  2013-11-14  NOTICE     E_NOTICE: Use of undefined constant T - assumed 'T'          {"file":"/path/to/DTail/error.php","line":29}
PHPErrorReporter  2013-11-14  ERROR      Uncaught exception                                           {"exception":{"class":"Exception","message":"$arr has no element with index: dyn->key","file":"/path/to/DTail/Utils/Arr.php:26","trace":["/path/to/DTail/bin/app.php:36"]}}
```

DynamoDB
-----
This tool was written to read log messages stored by [monolog](https://github.com/Seldaek/monolog/) using the [DynamoDB handler](https://github.com/Seldaek/monolog/blob/master/src/Monolog/Handler/DynamoDbHandler.php) and the DynamoDB structure is displayed on [Issue 259](https://github.com/Seldaek/monolog/issues/259).
