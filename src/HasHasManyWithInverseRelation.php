<?php

namespace Stayallive\Laravel\Eloquent\Relations;

use Illuminate\Support\Str;

trait HasHasManyWithInverseRelation
{
    public function hasManyWithInverse($related, $inverse = null, $foreignKey = null, $localKey = null): HasManyWithInverseRelation
    {
        /** @var \Illuminate\Database\Eloquent\Model $this */
        $instance = $this->newRelatedInstance($related);

        $inverse    = $inverse ?: Str::camel(class_basename($this));
        $localKey   = $localKey ?: $this->getKeyName();
        $foreignKey = $foreignKey ?: $this->getForeignKey();

        return new HasManyWithInverseRelation($instance->newQuery(), $this, $instance->getTable() . '.' . $foreignKey, $localKey, $inverse);
    }
}
