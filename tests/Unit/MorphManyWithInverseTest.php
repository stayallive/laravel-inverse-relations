<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Tests\Stubs\MorphManyWithInverse\PostModel;
use Tests\Stubs\MorphManyWithInverse\CommentModel;

beforeEach(function () {
    Schema::dropIfExists('test_morphmanywithinverse_posts');
    Schema::create('test_morphmanywithinverse_posts', function (Blueprint $table) {
        $table->bigIncrements('id');
    });

    Schema::dropIfExists('test_morphmanywithinverse_comments');
    Schema::create('test_morphmanywithinverse_comments', function (Blueprint $table) {
        $table->bigIncrements('id');

        $table->unsignedBigInteger('commentable_id');
        $table->string('commentable_type');
    });
});

test('children have the parent relationship automatically set when being created', function () {
    /** @var \Tests\Stubs\MorphManyWithInverse\PostModel $parent */
    $parent = PostModel::create([]);

    /** @var \Tests\Stubs\MorphManyWithInverse\CommentModel $child */
    $child = $parent->comments()->create([]);

    expect($child->relationLoaded('commentable'))->toBeTrue();
    expect($child->getRelations()['commentable']->id)->toBe($parent->id);
});

test('children have the parent relationship automatically set when being created using create many', function () {
    /** @var \Tests\Stubs\MorphManyWithInverse\PostModel $parent */
    $parent = PostModel::create([]);

    /** @var \Tests\Stubs\MorphManyWithInverse\CommentModel $child1 */
    /** @var \Tests\Stubs\MorphManyWithInverse\CommentModel $child2 */
    [$child1, $child2] = $parent->comments()->createMany([[], []]);

    expect($child1->relationLoaded('commentable'))->toBeTrue();
    expect($child1->getRelations()['commentable']->id)->toBe($parent->id);

    expect($child2->relationLoaded('commentable'))->toBeTrue();
    expect($child2->getRelations()['commentable']->id)->toBe($parent->id);
});

test('children have the parent relationship automatically set in creating event', function () {
    $parentId = null;

    /** @var \Tests\Stubs\MorphManyWithInverse\PostModel $parent */
    $parent = PostModel::create([]);

    CommentModel::creating(function (CommentModel $child) use (&$parentId) {
        if ($child->relationLoaded('commentable')) {
            $parentId = $child->getRelations()['commentable']->id;
        }
    });

    $parent->comments()->create([]);

    expect($parentId)->toBe($parent->id);
});

test('children have the parent relationship automatically set in saving event', function () {
    $parentId = null;

    /** @var \Tests\Stubs\MorphManyWithInverse\PostModel $parent */
    $parent = PostModel::create([]);

    CommentModel::saving(function (CommentModel $child) use (&$parentId) {
        if ($child->relationLoaded('commentable')) {
            $parentId = $child->getRelations()['commentable']->id;
        }
    });

    $parent->comments()->create([]);

    expect($parentId)->toBe($parent->id);
});

test('when creating, the children have the parent relationship automatically set when being resolved', function () {
    /** @var \Tests\Stubs\MorphManyWithInverse\PostModel $parent */
    $parent = PostModel::create([]);

    CommentModel::create([
        'commentable_id'   => $parent->id,
        'commentable_type' => PostModel::class,
    ]);

    /** @var \Tests\Stubs\MorphManyWithInverse\CommentModel $child */
    $child = $parent->comments->first();

    expect($child->relationLoaded('commentable'))->toBeTrue();
    expect($child->getRelations()['commentable']->id)->toBe($parent->id);
});

test('when creating, the children have the parent relationship automatically set when being eager loaded', function () {
    /** @var \Tests\Stubs\MorphManyWithInverse\PostModel $parent */
    $parent = PostModel::create([]);

    CommentModel::create([
        'commentable_id'   => $parent->id,
        'commentable_type' => PostModel::class,
    ]);

    // Load the parent from the database and eager load the relation
    $parent = $parent->fresh('comments');

    /** @var \Tests\Stubs\MorphManyWithInverse\CommentModel $child */
    $child = $parent->comments->first();

    expect($child->relationLoaded('commentable'))->toBeTrue();
    expect($child->getRelations()['commentable']->id)->toBe($parent->id);
});
