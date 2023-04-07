<?php

namespace Tests\Stubs\HasOneWithInverse;

use Illuminate\Database\Eloquent\Model;
use Stayallive\Laravel\Eloquent\Relations\HasOneWithInverseRelation;
use Stayallive\Laravel\Eloquent\Relations\HasHasOneWithInverseRelation;

/**
 * @property int                                       $id
 * @property \Tests\Stubs\HasOneWithInverse\ChildModel $child
 */
class ParentModel extends Model
{
    use HasHasOneWithInverseRelation;

    public $timestamps = [];

    protected $table   = 'test_hasonewithinverse_parents';
    protected $guarded = [];

    public function child(): HasOneWithInverseRelation
    {
        return $this->hasOneWithInverse(ChildModel::class, 'parent', 'parent_id');
    }
}
