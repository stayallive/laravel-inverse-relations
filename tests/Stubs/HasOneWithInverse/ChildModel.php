<?php

namespace Tests\Stubs\HasOneWithInverse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChildModel extends Model
{
    public $timestamps = [];

    protected $table   = 'test_hasonewithinverse_children';
    protected $guarded = [];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ParentModel::class, 'parent_id');
    }
}
