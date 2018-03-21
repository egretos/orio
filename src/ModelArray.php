<?php

namespace Orio;

/**
 * Class ModelArray
 */

class ModelArray
{
    private $models;

    public function setArray($array)
    {
        foreach ($array as $item) {
            $model = new Model();

            $model->WriteFromRecord($item);
            $this->models[] = $model;
        }
    }


    /**
     * @return array Model
     */
    public function getArray() {
        return $this->models;
    }

}