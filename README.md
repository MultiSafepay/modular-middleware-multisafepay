## Installation

You can install the package via composer:

```bash
composer require multisafepay/modular-middleware-multisafepay
```

You can publish with:

```bash
php artisan vendor:publish --tag="modular-middleware"

```
## Finialize

You must add the providers into config/app.php
```bash
\ModularMultiSafepay\ModularMultiSafepay\ModularMiddlewareMultiSafepayServiceProvider::class,
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [MultiSafepay](https://github.com/MultiSafepay)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
