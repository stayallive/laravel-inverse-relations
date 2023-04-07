# Laravel Inverse Relations

[![Latest Version](https://img.shields.io/github/release/stayallive/laravel-inverse-relations.svg?style=flat-square)](https://github.com/stayallive/laravel-inverse-relations/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/github/actions/workflow/status/stayallive/laravel-inverse-relations/ci.yaml?branch=master&style=flat-square)](https://github.com/stayallive/laravel-inverse-relations/actions/workflows/ci.yaml)
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

## Caveats

Because the inverse relation stores the parent by reference (not cloned), you need to be careful when you are using the relation since you will be modifying the parent model. This is nothing new to this package since eager loading does the same thing but I thought to mention it since it could catch you off guard.

There is one other downside to the inverse relation being stored as a reference since it creates a circular reference. This means that you cannot recusively serialize the model that has the inverse relation.
Laravel does this for example when you pass the model in a queued job since the `SerializesModels` trait will also try to store which relations were loaded when the model was queued to load those relations back causing once the job is being processed.
This causes an infinite loop trying to figure out which relations are loaded recursively, eating up memory until the process is killed by the OS or crashes.

To prevent this you can either pass your model to your job using `$model->withoutRelations()` or you can disable the relations loading on your model by adding the following method to your model:

```php
    public function getQueueableRelations(): array
    {
        return [];
    }
```

This disables the collection and loading of relations on the model when it (un-)serialized for the queued job.

Personally I put this in my base model since I never want to load the relations loaded when I push a job on the queue since they are mostly not useful in the context of the job and apart from guarding against circular references this also saves database queries (sometimes a lot) retrieving unused relations.

## Security Vulnerabilities

If you discover a security vulnerability within this package, please send an e-mail to Alex Bouma at `alex+security@bouma.me`. All security vulnerabilities will be swiftly addressed.

## License

This package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
