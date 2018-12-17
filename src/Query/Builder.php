<?php

namespace Orio\Query;

use Orio\Entity\Document;
use Orio\Entity\Rid;
use Orio\Query\Commands\ICommand;
use Orio\Query\Commands\Select;

class Builder
{
    /**
     * @param string|Rid|Document|Rid[] $target
     * @param ICommand[]|string[]|string $projections
     * @param null $let
     * @return Select
     */
    public function select($target = null, $projections = null, $let = null)
    {
        $command = new Select($target, $projections, $let);
        return $command;
    }

    public function insert()
    {
        // TODO code here
    }

    public function update()
    {
        // TODO code here
    }

    public function delete()
    {
        // TODO code here
    }

    public function traverse()
    {
        // TODO code here
    }

    public function truncateClass()
    {
        // TODO code here
    }

    public function truncateCluster()
    {
        // TODO code here
    }

    public function truncateRecord()
    {
        // TODO code here
    }
}