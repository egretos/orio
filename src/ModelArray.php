<?php

namespace Orio;

/**
 * Class ModelArray
 */

class ModelArray
{
    private $models;

    public function fromRecordArray($array)
    {
        foreach ($array as $item) {
            $model = new Model();

            $model->writeFromRecord($item);
            $this->models[] = $model;
        }
    }


    /**
     * @return array Model
     */
    public function getArray()
    {
        return $this->models;
    }

    /**
     * @param $number number of model
     * @return Model
     */
    public function getModel($number)
    {
        return $this->models[$number];
    }
}
