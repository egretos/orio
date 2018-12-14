<?php

namespace Orio\Entity;

/**
 * Class Document
 * @package Orio\Entity
 *
 * @property Rid $rid
 */
class Document
{
    public $rid;
    public $version;
    public $class;
    public $size;
    public $fields;
    public $type;

    public $oData;

    public function setRid($rid)
    {
        if (is_string($rid)) {
            $this->rid = new Rid($rid);
        } elseif ($rid instanceof Rid) {
            $this->rid = $rid;
        }
    }
}