<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Tests\Stubs\HasManyWithInverse\ChildModel;
use Tests\Stubs\HasManyWithInverse\ParentModel;

beforeEach(function () {
    Schema::dropIfExists('test_hasmanywithinverse_parents');
    Schema::create('test_hasmanywithinverse_parents', function (Blueprint $table) {
        $table->bigIncrements('id');
    });

    Schema::dropIfExists('test_hasmanywithinverse_children');
    Schema::create('test_hasmanywithinverse_children', function (Blueprint $table) {
        $table->bigIncrements('id');

        $table->unsignedBigInteger('parent_id');
    });
});

test('inverse relationship name can be automatically guessed if not provided', function () {
    /** @var \Tests\Stubs\HasManyWithInverse\ParentModel $parent */
    $parent = ParentModel::create([]);

    /** @var \Tests\Stubs\HasManyWithInverse\ChildModel $child */
    $child = $parent->childrenDefaultInverse()->create([]);

    expect($child->relationLoaded('parentModel'))->toBeTrue();
    expect($child->getRelations()['parentModel']->id)->toBe($parent->id);
});

test('children have the parent relationship automatically set when being created', function () {
    /** @var \Tests\Stubs\HasManyWithInverse\ParentModel $parent */
    $parent = ParentModel::create([]);

    /** @var \Tests\Stubs\HasManyWithInverse\ChildModel $child */
    $child = $parent->children()->create([]);

    expect($child->relationLoaded('parent'))->toBeTrue();
    expect($child->getRelations()['parent']->id)->toBe($parent->id);
});

test('children have the parent relationship automatically set when being created using create many', function () {
    /** @var \Tests\Stubs\HasManyWithInverse\ParentModel $parent */
    $parent = ParentModel::create([]);

    /** @var \Tests\Stubs\HasManyWithInverse\ChildModel $child1 */
    /** @var \Tests\Stubs\HasManyWithInverse\ChildModel $child2 */
    [$child1, $child2] = $parent->children()->createMany([[], []]);

    expect($child1->relationLoaded('parent'))->toBeTrue();
    expect($child1->getRelations()['parent']->id)->toBe($parent->id);

    expect($child2->relationLoaded('parent'))->toBeTrue();
    expect($child2->getRelations()['parent']->id)->toBe($parent->id);
});

test('children have the parent relationship automatically set in creating event', function () {
    $parentId = null;

    /** @var \Tests\Stubs\HasManyWithInverse\ParentModel $parent */
    $parent = ParentModel::create([]);

    ChildModel::creating(function (ChildModel $child) use (&$parentId) {
        if ($child->relationLoaded('parent')) {
            $parentId = $child->getRelations()['parent']->id;
        }
    });

    $parent->children()->create([]);

    expect($parentId)->toBe($parent->id);
});

test('children have the parent relationship automatically set in saving event', function () {
    $parentId = null;

    /** @var \Tests\Stubs\HasManyWithInverse\ParentModel $parent */
    $parent = ParentModel::create([]);

    ChildModel::saving(function (ChildModel $child) use (&$parentId) {
        if ($child->relationLoaded('parent')) {
            $parentId = $child->getRelations()['parent']->id;
        }
    });

    $parent->children()->create([]);

    expect($parentId)->toBe($parent->id);
});

test('when creating, the children have the parent relationship automatically set when being resolved', function () {
    /** @var \Tests\Stubs\HasManyWithInverse\ParentModel $parent */
    $parent = ParentModel::create([]);

    ChildModel::create(['parent_id' => $parent->id]);

    /** @var \Tests\Stubs\HasManyWithInverse\ChildModel $child */
    $child = $parent->children->first();

    expect($child->relationLoaded('parent'))->toBeTrue();
    expect($child->getRelations()['parent']->id)->toBe($parent->id);
});

test('when creating, the children have the parent relationship automatically set when being eager loaded', function () {
    /** @var \Tests\Stubs\HasManyWithInverse\ParentModel $parent */
    $parent = ParentModel::create([]);

    ChildModel::create(['parent_id' => $parent->id]);

    // Load the parent from the database and eager load the relation
    $parent = $parent->fresh('children');

    /** @var \Tests\Stubs\HasManyWithInverse\ChildModel $child */
    $child = $parent->children->first();

    expect($child->relationLoaded('parent'))->toBeTrue();
    expect($child->getRelations()['parent']->id)->toBe($parent->id);
});
