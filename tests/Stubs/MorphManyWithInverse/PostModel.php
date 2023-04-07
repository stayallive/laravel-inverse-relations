<?php

namespace Tests\Stubs\MorphManyWithInverse;

use Illuminate\Database\Eloquent\Model;
use Stayallive\Laravel\Eloquent\Relations\MorphManyWithInverseRelation;
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

    public function comments(): MorphManyWithInverseRelation
    {
        return $this->morphManyWithInverse(CommentModel::class, 'commentable');
    }
}
