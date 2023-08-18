# State Machine For Order Laravel Package

## Installation

By default this package will be installed in pet-shop-api project
Clone this repo into `packages` folder in: https://github.com/mayanksdudakiya/pet-shop-api

Add below line in composer.json if not exists and run the `composer require mayanksdudakiya/state-machine:dev-main`

```bash
"require": {
    "mayanksdudakiya/state-machine": "dev-main",
},
"repositories": [
        {
            "type": "path",
            "url": "packages/mayanksdudakiya/state-machine",
            "options": {
                "symlink": true
            }
        }
    ]
```


### Testing

```bash
composer test
```

### Swagger Doc

```bash
{{baseUrl}}/api/documentation#/
```

### Swagger Currency Converter Demo


