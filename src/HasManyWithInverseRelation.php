<?php

namespace Stayallive\Laravel\Eloquent\Relations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @template TRelatedModel of \Illuminate\Database\Eloquent\Model
 *
 * @extends \Illuminate\Database\Eloquent\Relations\HasMany<TRelatedModel>
 */
class HasManyWithInverseRelation extends HasMany
{
    use WithInverseOneOrManyRelation;

    public function __construct(Builder $query, Model $parent, string $foreignKey, string $localKey, string $relationToParent)
    {
        $this->relationToParent = $relationToParent;

        parent::__construct($query, $parent, $foreignKey, $localKey);
    }
}
