<?php

namespace Stayallive\Laravel\Eloquent\Relations;

use Illuminate\Support\Str;

trait HasHasOneWithInverseRelation
{
    public function hasOneWithInverse($related, $inverse = null, $foreignKey = null, $localKey = null): HasOneWithInverseRelation
    {
        /** @var \Illuminate\Database\Eloquent\Model $this */
        $instance = $this->newRelatedInstance($related);

        $inverse    = $inverse ?: Str::camel(class_basename($this));
        $localKey   = $localKey ?: $this->getKeyName();
        $foreignKey = $foreignKey ?: $this->getForeignKey();

        return new HasOneWithInverseRelation($instance->newQuery(), $this, $instance->getTable() . '.' . $foreignKey, $localKey, $inverse);
    }
}
