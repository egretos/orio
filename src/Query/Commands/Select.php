<?php

namespace Orio\Query\Commands;

use Orio\Query\Parameters\Target;
use Orio\Query\Parameters\Where;

class Select extends AbstractCommand
{
//    /**
//     * Select constructor.
//     * @param string|Target $from
//     * @param null $projections
//     * @param null $let
//     */
    /*public function __construct($from, $projections = null, $let = null)
    {
        if (is_string($from)) {
            $from = new Target($from);
        }
        $this->addParameter($from);
    }*/

    public function optionalParameters()
    {
        return [
            Where::class,
        ];
    }

    public function requiredParameters()
    {
        return [
            Target::class
        ];
    }
}