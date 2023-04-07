<?php

namespace Tests\Stubs\MorphManyWithInverse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int                                      $id
 * @property \Illuminate\Database\Eloquent\Collection $commentable
 */
class CommentModel extends Model
{
    public $timestamps = [];

    protected $table   = 'test_morphmanywithinverse_comments';
    protected $guarded = [];

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}
