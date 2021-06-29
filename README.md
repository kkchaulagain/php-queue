
## Installation

You can install the package via composer:

```bash
composer require kkchaulagain/php-queue
```

## Usage (Just Like)

```php
class MainQueue extends kkchaulagain\phpQueue\BaseQueue{

}
```

```php
$data = [
    'test'=>true
];
MainQueue::dispatch($data)->onQueue('mainQueue');
```


```php

use kkchaulagain\phpQueue\Consumer;
Consumer::consume('test','vhost');
```


## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
