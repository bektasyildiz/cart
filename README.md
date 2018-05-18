# Cart

[![Build Status](https://travis-ci.org/bektas/cart.svg?branch=master)](https://travis-ci.org/bektas/cart)
[![styleci](https://styleci.io/repos/CHANGEME/shield)](https://styleci.io/repos/CHANGEME)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bektas/cart/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bektas/cart/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/CHANGEME/mini.png)](https://insight.sensiolabs.com/projects/CHANGEME)
[![Coverage Status](https://coveralls.io/repos/github/bektas/cart/badge.svg?branch=master)](https://coveralls.io/github/bektas/cart?branch=master)

[![Packagist](https://img.shields.io/packagist/v/bektas/cart.svg)](https://packagist.org/packages/bektas/cart)
[![Packagist](https://poser.pugx.org/bektas/cart/d/total.svg)](https://packagist.org/packages/bektas/cart)
[![Packagist](https://img.shields.io/packagist/l/bektas/cart.svg)](https://packagist.org/packages/bektas/cart)

Package description: CHANGE ME

## Installation

Install via composer
```bash
composer require bektas/cart
```

### Register Service Provider

**Note! This and next step are optional if you use laravel>=5.5 with package
auto discovery feature.**

Add service provider to `config/app.php` in `providers` section
```php
Bektas\Cart\ServiceProvider::class,
```

### Register Facade

Register package facade in `config/app.php` in `aliases` section
```php
Bektas\Cart\Facades\Cart::class,
```

### Publish Configuration File

```bash
php artisan vendor:publish --provider="Bektas\Cart\ServiceProvider" --tag="config"
```

## Usage

CHANGE ME

## Security

If you discover any security related issues, please email bektasstar@gmail.com
instead of using the issue tracker.

## Credits

- [Bektaş](https://github.com/bektas/cart)
- [All contributors](https://github.com/bektas/cart/graphs/contributors)

This package is bootstrapped with the help of
[melihovv/laravel-package-generator](https://github.com/melihovv/laravel-package-generator).
