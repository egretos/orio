<?php

namespace Orio\Query;

use Orio\Query\Commands\Select;
use Orio\Query\Parameters\Target;

class Builder
{
    public function select($from, $projections = null, $let = null)
    {
        $command = new Select();
        $command->addParameter(new Target($from));

        return $command->build();
    }

}