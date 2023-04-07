<?php

namespace Stayallive\Laravel\Eloquent\Relations;

trait HasHasOneWithInverseRelation
{
    public function hasOneWithInverse($related, $inverse, $foreignKey = null, $localKey = null): HasOneWithInverseRelation
    {
        /** @var \Illuminate\Database\Eloquent\Model $this */
        $instance   = $this->newRelatedInstance($related);
        $localKey   = $localKey ?: $this->getKeyName();
        $foreignKey = $foreignKey ?: $this->getForeignKey();

        return new HasOneWithInverseRelation($instance->newQuery(), $this, $instance->getTable() . '.' . $foreignKey, $localKey, $inverse);
    }
}
