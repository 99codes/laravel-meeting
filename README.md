# Laravel Meeting

[![Latest Version on Packagist](https://img.shields.io/packagist/v/nncodes/laravel-meeting.svg?style=flat-square)](https://packagist.org/packages/nncodes/laravel-meeting)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/99codes/laravel-meeting/run-tests?label=tests)](https://github.com/nncodes/laravel-meeting/actions?query=workflow%3ATests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/nncodes/laravel-meeting.svg?style=flat-square)](https://packagist.org/packages/nncodes/laravel-meeting)


Handle any kind of meeting with Laravel

## Installation

You can install the package via composer:

```bash
composer require nncodes/laravel-meeting
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Nncodes\Meeting\MeetingServiceProvider" --tag="migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Nncodes\Meeting\MeetingServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage


## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Leonardo Poletto](https://github.com/leopoletto)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
