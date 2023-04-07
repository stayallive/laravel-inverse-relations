<?php

namespace Tests\Stubs\MorphManyWithInverse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Stayallive\Laravel\Eloquent\Relations\HasMorphManyWithInverseRelation;

/**
 * @property int                                      $id
 * @property \Illuminate\Database\Eloquent\Collection $comments
 */
class PostModel extends Model
{
    use HasMorphManyWithInverseRelation;

    public $timestamps = [];

    protected $table   = 'test_morphmanywithinverse_posts';
    protected $guarded = [];

    public function comments(): MorphMany
    {
        // The `commentable` argument (second) is the name of the inverse relationship as defined in the CommentModel
        return $this->morphManyWithInverse(CommentModel::class, 'commentable');
    }
}
