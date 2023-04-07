<?php

namespace Tests\Stubs\HasManyWithInverse;

use Illuminate\Database\Eloquent\Model;
use Stayallive\Laravel\Eloquent\Relations\HasManyWithInverseRelation;
use Stayallive\Laravel\Eloquent\Relations\HasHasManyWithInverseRelation;

/**
 * @property int                                      $id
 * @property \Illuminate\Database\Eloquent\Collection $children
 */
class ParentModel extends Model
{
    use HasHasManyWithInverseRelation;

    public $timestamps = [];

    protected $table   = 'test_hasmanywithinverse_parents';
    protected $guarded = [];

    public function children(): HasManyWithInverseRelation
    {
        return $this->hasManyWithInverse(ChildModel::class, 'parent', 'parent_id');
    }
}
