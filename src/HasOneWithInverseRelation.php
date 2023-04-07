<?php

namespace Stayallive\Laravel\Eloquent\Relations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @template TRelatedModel of \Illuminate\Database\Eloquent\Model
 *
 * @extends \Illuminate\Database\Eloquent\Relations\HasOne<TRelatedModel>
 */
class HasOneWithInverseRelation extends HasOne
{
    use WithInverseOneOrManyRelation;

    public function __construct(Builder $query, Model $parent, string $foreignKey, string $localKey, string $relationToParent)
    {
        $this->relationToParent = $relationToParent;

        parent::__construct($query, $parent, $foreignKey, $localKey);
    }
}
