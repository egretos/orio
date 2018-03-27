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
    public $rids;
    public $class;
    public $size;

    /**
     * @param $bag Bag
     */
    public function writeFromBag($bag)
    {
        $this->rids = $bag->getRids();
        $this->size = $bag->getSize();
    }

}
