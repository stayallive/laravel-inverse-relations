<?php

namespace Stayallive\Laravel\Eloquent\Relations;

trait HasHasManyWithInverseRelation
{
    public function hasManyWithInverse($related, $inverse, $foreignKey = null, $localKey = null): HasManyWithInverseRelation
    {
        /** @var \Illuminate\Database\Eloquent\Model $this */
        $instance   = $this->newRelatedInstance($related);
        $localKey   = $localKey ?: $this->getKeyName();
        $foreignKey = $foreignKey ?: $this->getForeignKey();

        return new HasManyWithInverseRelation($instance->newQuery(), $this, $instance->getTable() . '.' . $foreignKey, $localKey, $inverse);
    }
}
