# Quickly Generate Laravel Mini Crud Generator

## :inbox_tray: Installation

You can install this package via composer:

```bash
composer require davion153808/mini-crud-generator
```

and after installation you can run following command to publish config files:

``` 
php artisan vendor:publish --provider="DAVION153808\MiniCRUDGenerator\MiniCRUDGeneratorServiceProvider" --tag="config"
```
## :gear: Configuration
for configure this package go to `config/minicrud.php` and if you want to customize namespace you can do like this

```php
<?php  
  
return [
    'namespace' => 'Laravel',
];
```

add line in `composer.json` `autoload` block

```
"autoload": {
        "psr-4": {
            // 
            "Laravel\\": "modules/"
        }
    },
```
and then 

```
composer dump-autoload
```
## Usage

```
php artisan make:coreFeature--all 

php artisan make:coreFeature--logic

php artisan make:coreFeature--view

```

## Credits

-   [Nay Ba La](https://github.com/naybala)
-   [All Contributors](../../contributors)

## :scroll: License 

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
