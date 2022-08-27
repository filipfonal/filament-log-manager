# Filament Log Manager

[![Latest Version on Packagist](https://img.shields.io/packagist/v/filipfonal/filament-log-manager.svg?style=flat-square)](https://packagist.org/packages/filipfonal/filament-log-manager)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/filipfonal/filament-log-manager/run-tests?label=tests)](https://github.com/filipfonal/filament-log-manager/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/filipfonal/filament-log-manager/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/filipfonal/filament-log-manager/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/filipfonal/filament-log-manager.svg?style=flat-square)](https://packagist.org/packages/filipfonal/filament-log-manager)

A simple and clear interface to preview, download and delete Laravel log files using Filament Admin.

![](./.github/resources/screenshot_light_mode.png)

## Filament Admin Panel

This package is tailored for [Filament Admin Panel](https://filamentphp.com/).

Make sure you have installed the admin panel before you continue with the installation. You can check the [documentation here](https://filamentphp.com/docs/admin)

## Installation

You can install the package via composer:

```bash
composer require filipfonal/filament-log-manager
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-log-manager-config"
```

You can publish translations files with:

```bash
php artisan vendor:publish --tag="filament-log-manager-translations"
```

## Usage

Once installed, the package is ready to use. You will be able to see it in your Filament admin panel.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Filip Fonal](https://github.com/filipfonal)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
