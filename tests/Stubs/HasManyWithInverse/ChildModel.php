<?php

namespace Tests\Stubs\HasManyWithInverse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChildModel extends Model
{
    public $timestamps = [];

    protected $table   = 'test_hasmanywithinverse_children';
    protected $guarded = [];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ParentModel::class, 'parent_id');
    }
}
