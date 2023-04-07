# Laravel Inverse Relations

[![Latest Version](https://img.shields.io/github/release/stayallive/laravel-inverse-relations.svg?style=flat-square)](https://github.com/stayallive/laravel-inverse-relations/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/github/workflow/status/stayallive/laravel-inverse-relations/CI/master.svg?style=flat-square)](https://github.com/stayallive/laravel-inverse-relations/actions/workflows/ci.yaml)
[![Total Downloads](https://img.shields.io/packagist/dt/stayallive/laravel-inverse-relations.svg?style=flat-square)](https://packagist.org/packages/stayallive/laravel-inverse-relations)

Inverse relations for Laravel Eloquent models.

[Jonathan Reinink](https://github.com/reinink) wrote a great blog post about [optimizing circular relationships in Laravel](https://reinink.ca/articles/optimizing-circular-relationships-in-laravel). This [package](https://github.com/archtechx/laravel-hasmanywithinverse) ran with that idea and implemented it for the `hasMany` relation. This package tries to improve on that by implementing it for the `hasOne` and `morphMany` relations too.

## Installation

```bash
composer require stayallive/laravel-inverse-relations
```

## Usage

Adding the `HasHasManyWithInverseRelation`, `HasHasOneWithInverseRelation` and/or `HasMorphManyWithInverseRelation` trait will provide you with the helper methods to setup the inverse relations.

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stayallive\Laravel\Eloquent\UUID\UsesUUID;

class SomeModel extends Model
{
    use UsesUUID;

    /**
     * This method is not needed but can be used to override which attribute is filled with the UUID.
     */
    public function getUUIDAttributeName(): string
    {
        return $this->getKeyName();
    }
}
```

## Security Vulnerabilities

If you discover a security vulnerability within this package, please send an e-mail to Alex Bouma at `alex+security@bouma.me`. All security vulnerabilities will be swiftly addressed.

## License

This package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
