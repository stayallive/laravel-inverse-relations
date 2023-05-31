<?php

namespace Stayallive\Laravel\Eloquent\Relations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

trait WithInverseOneOrManyRelation
{
    /** @var string */
    protected $relationToParent;

    public function create(array $attributes = [])
    {
        return tap($this->related->newInstance($attributes), function (Model $instance) {
            $this->setForeignAttributesForCreate($instance);

            $instance->setRelation($this->relationToParent, $this->getParent());

            $instance->save();
        });
    }

    public function getResults()
    {
        /** @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model $resultOrResults */
        $resultOrResults = parent::getResults();

        if ($resultOrResults instanceof Model) {
            $resultOrResults->setRelation($this->relationToParent, $this->getParent());
        } elseif ($resultOrResults instanceof Collection) {
            $resultOrResults->each(function (Model $model) {
                $model->setRelation($this->relationToParent, $this->getParent());
            });
        } else {
            throw_unless($resultOrResults === null, new \RuntimeException('Unexpected result value encountered.'));
        }

        return $resultOrResults;
    }

    protected function matchOneOrMany(array $models, Collection $results, $relation, $type): array
    {
        $result = parent::matchOneOrMany($models, $results, $relation, $type);

        /** @var \Illuminate\Database\Eloquent\Model $model */
        foreach ($result as $model) {
            if ($model->relationLoaded($relation)) {
                /** @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model $relatedModelOrModels */
                $relatedModelOrModels = $model->getRelation($relation);

                if ($relatedModelOrModels instanceof Model) {
                    $relatedModelOrModels->setRelation($this->relationToParent, $model);
                } elseif ($relatedModelOrModels instanceof Collection) {
                    $relatedModelOrModels->each(function (Model $relatedModel) use ($model) {
                        $relatedModel->setRelation($this->relationToParent, $model);
                    });
                } else {
                    throw_unless($relatedModelOrModels === null, new \RuntimeException('Unexpected relation value encountered.'));
                }
            }
        }

        return $result;
    }
}
