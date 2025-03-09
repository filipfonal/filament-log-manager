# Filament Log Manager

[![Latest Version on Packagist](https://img.shields.io/packagist/v/filipfonal/filament-log-manager.svg?style=flat-square)](https://packagist.org/packages/filipfonal/filament-log-manager)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/filipfonal/filament-log-manager/run-tests.yml?branch=main&label=tests)](https://github.com/filipfonal/filament-log-manager/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/filipfonal/filament-log-manager/fix-php-code-style-issues.yml?branch=main&label=code%20style)](https://github.com/filipfonal/filament-log-manager/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
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

After that, you can register the plugin in the Filament Panel Provider (This is by default AdminPanelProvider.php)

```php
public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            ...
            \FilipFonal\FilamentLogManager\FilamentLogManager::make(),
        ]);
}
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-log-manager-config"
```

You can publish translations files with:

```bash
php artisan vendor:publish --tag="filament-log-manager-translations"
```

To ensure correct styling, make sure the logs blade file is included in your [panel's theme](https://filamentphp.com/docs/3.x/panels/themes#creating-a-custom-theme). See example below
```js
import preset from '../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './vendor/filipfonal/filament-log-manager/resources/views/pages/logs.blade.php',
        ...
    ],
    ...
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
