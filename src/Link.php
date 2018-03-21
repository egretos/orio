<?php

namespace Orio;

use PhpOrient\Protocols\Binary\Data\Bag;
use PhpOrient\Protocols\Binary\Data\ID;

/**
 * Created by PhpStorm.
 * User: egretos
 * Date: 30.12.17
 * Time: 3:30
 */
class Link
{
    /**
     * @var $rid ID
     */
    public $rid;
    public $type;
    public $size;

    /**
     * @param $bag Bag
     */
    public function WriteFromBag($bag) {
        $this->rid      = $bag->getRids();
        $this->type     = $bag->getType();
        $this->size     = $bag->getSize();
    }

}