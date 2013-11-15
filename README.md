PHPErrorReporter
================

Report PHP Error messages to DynamoDB for further analysis

Installing
-------

To install with composer, add: `"otternq/php-error-reporter": "dev-master"` to _composer.json_ in the **require** section:

```json
"require": {
    "php": ">=5.3.3",
    "otternq/php-error-reporter": "dev-master"
}
```

then run `php composer.phar update` (or `php composer.phar install` depending on the situation) and let composer do the rest.

Usage
-------

```php
require 'vendor/autoload.php';

use Otternq\PHPErrorReporter;

$per = new PHPErrorReporter(array(
  'awsKey' => YOUR_AWS_KEY,
  'dynamoTable' => YOUR_DYNAMO_TABLE,
  'application' => NAME_OF_YOUR_APPLICATION
));
```

DynamoDB Setup
-------
