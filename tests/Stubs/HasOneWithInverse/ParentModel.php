<?php

namespace Tests\Stubs\HasOneWithInverse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
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

    public function child(): HasOne
    {
        // The `parent` argument (second) is the name of the inverse relationship as defined in the ChildModel
        return $this->hasOneWithInverse(ChildModel::class, 'parent', 'parent_id');
    }
}
