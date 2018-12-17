<?php

namespace Orio\Query\Commands;

use Orio\Query\Parameters\Projection;
use Orio\Query\Parameters\Target;
use Orio\Query\Parameters\Where;

class Select extends AbstractCommand
{
    /**
     * Select constructor.
     * @param string|Target $from
     * @param null $projections
     * @param null $let
     */
    public function __construct($from = null, $projections = null, $let = null)
    {
        if ($from) {
            $this->pushParameter(new Target($from));
        }

        if ($projections) {
            $this->pushParameter(new Projection($projections));
        }
    }

    public static function optionalParameters()
    {
        return [
            Projection::class,
            Where::class,
        ];
    }

    public static function requiredParameters()
    {
        return [
            Target::class
        ];
    }

    public static function parametersOrder()
    {
        return [
            Projection::class,
            Target::class,
            Where::class,
        ];
    }
}