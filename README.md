# Laravel Inverse Relations

[![Latest Version](https://img.shields.io/github/release/stayallive/laravel-inverse-relations.svg?style=flat-square)](https://github.com/stayallive/laravel-inverse-relations/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/github/workflow/status/stayallive/laravel-inverse-relations/CI/master.svg?style=flat-square)](https://github.com/stayallive/laravel-inverse-relations/actions/workflows/ci.yaml)
[![Total Downloads](https://img.shields.io/packagist/dt/stayallive/laravel-inverse-relations.svg?style=flat-square)](https://packagist.org/packages/stayallive/laravel-inverse-relations)

Inverse relations for Laravel Eloquent models.

[Jonathan Reinink](https://github.com/reinink) wrote a great blog post about [optimizing circular relationships in Laravel](https://reinink.ca/articles/optimizing-circular-relationships-in-laravel).
The package [stancl/laravel-hasmanywithinverse](https://github.com/archtechx/laravel-hasmanywithinverse) ran with that idea and implemented it for the `hasMany` relation. This package improves on that by implementing it for the `hasOne` and `morphMany` relations too.

In short, this package allows you to define inverse relations on your models. This means that you can define a relation on a model that points to another model. This is useful when you have a circular relationship between two models and you want to be able to access the inverse relation without having to load the other model from the database.

## Installation

```bash
composer require stayallive/laravel-inverse-relations
```

## Usage

Adding the `HasHasManyWithInverseRelation`, `HasHasOneWithInverseRelation` and/or `HasMorphManyWithInverseRelation` trait will provide you with the helper methods to setup the inverse relations.

Check out the test stubs for examples on how to use the trait on your models:

- [HasMany](tests/Stubs/HasManyWithInverse)
- [HasOne](tests/Stubs/HasOneWithInverse)
- [MorphMany](tests/Stubs/MorphManyWithInverse)

## Security Vulnerabilities

If you discover a security vulnerability within this package, please send an e-mail to Alex Bouma at `alex+security@bouma.me`. All security vulnerabilities will be swiftly addressed.

## License

This package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
