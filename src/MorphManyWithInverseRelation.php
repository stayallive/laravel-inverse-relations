<?php

namespace Stayallive\Laravel\Eloquent\Relations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @template TRelatedModel of \Illuminate\Database\Eloquent\Model
 *
 * @extends \Illuminate\Database\Eloquent\Relations\MorphMany<TRelatedModel>
 */
class MorphManyWithInverseRelation extends MorphMany
{
    use WithInverseOneOrManyRelation;

    public function __construct(Builder $query, Model $parent, $type, $id, $localKey, string $relationToParent)
    {
        $this->relationToParent = $relationToParent;

        parent::__construct($query, $parent, $type, $id, $localKey);
    }
}
