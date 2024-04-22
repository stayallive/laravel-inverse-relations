<?php

namespace Tests\Stubs\HasManyWithInverse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Stayallive\Laravel\Eloquent\Relations\HasHasManyWithInverseRelation;

/**
 * @property int                                      $id
 * @property \Illuminate\Database\Eloquent\Collection $children
 * @property \Illuminate\Database\Eloquent\Collection $childrenDefaultInverse
 */
class ParentModel extends Model
{
    use HasHasManyWithInverseRelation;

    public $timestamps = [];

    protected $table   = 'test_hasmanywithinverse_parents';
    protected $guarded = [];

    public function children(): HasMany
    {
        // The `parent` argument (second) is the name of the inverse relationship as defined in the ChildModel
        return $this->hasManyWithInverse(ChildModel::class, 'parent', 'parent_id');
    }

    public function childrenDefaultInverse(): HasMany
    {
        return $this->hasManyWithInverse(ChildModel::class, null, 'parent_id');
    }
}
