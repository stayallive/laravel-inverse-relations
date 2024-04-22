<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Tests\Stubs\HasOneWithInverse\ChildModel;
use Tests\Stubs\HasOneWithInverse\ParentModel;

beforeEach(function () {
    Schema::dropIfExists('test_hasonewithinverse_parents');
    Schema::create('test_hasonewithinverse_parents', function (Blueprint $table) {
        $table->bigIncrements('id');
    });

    Schema::dropIfExists('test_hasonewithinverse_children');
    Schema::create('test_hasonewithinverse_children', function (Blueprint $table) {
        $table->bigIncrements('id');

        $table->unsignedBigInteger('parent_id');
    });
});

test('inverse relationship name can be automatically guessed if not provided', function () {
    /** @var \Tests\Stubs\HasOneWithInverse\ParentModel $parent */
    $parent = ParentModel::create([]);

    /** @var \Tests\Stubs\HasOneWithInverse\ChildModel $child */
    $child = $parent->childDefaultInverse()->create([]);

    expect($child->relationLoaded('parentModel'))->toBeTrue();
    expect($child->getRelations()['parentModel']->id)->toBe($parent->id);
});

test('child has the parent relationship automatically set when being created', function () {
    /** @var \Tests\Stubs\HasOneWithInverse\ParentModel $parent */
    $parent = ParentModel::create([]);

    /** @var \Tests\Stubs\HasOneWithInverse\ChildModel $child */
    $child = $parent->child()->create([]);

    expect($child->relationLoaded('parent'))->toBeTrue();
    expect($child->getRelations()['parent']->id)->toBe($parent->id);
});

test('child has the parent relationship automatically set in creating event', function () {
    $parentId = null;

    /** @var \Tests\Stubs\HasOneWithInverse\ParentModel $parent */
    $parent = ParentModel::create([]);

    ChildModel::creating(function (ChildModel $child) use (&$parentId) {
        if ($child->relationLoaded('parent')) {
            $parentId = $child->getRelations()['parent']->id;
        }
    });

    $parent->child()->create([]);

    expect($parentId)->toBe($parent->id);
});

test('child has the parent relationship automatically set in saving event', function () {
    $parentId = null;

    /** @var \Tests\Stubs\HasOneWithInverse\ParentModel $parent */
    $parent = ParentModel::create([]);

    ChildModel::saving(function (ChildModel $child) use (&$parentId) {
        if ($child->relationLoaded('parent')) {
            $parentId = $child->getRelations()['parent']->id;
        }
    });

    $parent->child()->create([]);

    expect($parentId)->toBe($parent->id);
});

test('when creating, the child has the parent relationship automatically set when being resolved', function () {
    /** @var \Tests\Stubs\HasOneWithInverse\ParentModel $parent */
    $parent = ParentModel::create([]);

    ChildModel::create(['parent_id' => $parent->id]);

    $child = $parent->child;

    expect($child->relationLoaded('parent'))->toBeTrue();
    expect($child->getRelations()['parent']->id)->toBe($parent->id);
});

test('when creating, the child has the parent relationship automatically set when being eager loaded', function () {
    /** @var \Tests\Stubs\HasOneWithInverse\ParentModel $parent */
    $parent = ParentModel::create([]);

    ChildModel::create(['parent_id' => $parent->id]);

    // Load the parent from the database and eager load the relation
    $parent = $parent->fresh('child');

    $child = $parent->child;

    expect($child->relationLoaded('parent'))->toBeTrue();
    expect($child->getRelations()['parent']->id)->toBe($parent->id);
});
