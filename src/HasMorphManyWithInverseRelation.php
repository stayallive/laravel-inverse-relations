<?php

namespace Stayallive\Laravel\Eloquent\Relations;

trait HasMorphManyWithInverseRelation
{
    /**
     * Define a polymorphic one-to-many relationship with inverse.
     *
     * @param string      $related
     * @param string      $name
     * @param string|null $type
     * @param string|null $id
     * @param string|null $localKey
     *
     * @return \Stayallive\Laravel\Eloquent\Relations\MorphManyWithInverseRelation
     */
    public function morphManyWithInverse($related, $name, $type = null, $id = null, $localKey = null): MorphManyWithInverseRelation
    {
        $instance = $this->newRelatedInstance($related);

        // Here we will gather up the morph type and ID for the relationship so that we
        // can properly query the intermediate table of a relation. Finally, we will
        // get the table and create the relationship instances for the developers.
        [$type, $id] = $this->getMorphs($name, $type, $id);

        $table = $instance->getTable();

        $localKey = $localKey ?: $this->getKeyName();

        return new MorphManyWithInverseRelation($instance->newQuery(), $this, $table . '.' . $type, $table . '.' . $id, $localKey, $name);
    }
}
