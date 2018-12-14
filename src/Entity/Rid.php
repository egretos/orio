<?php

namespace Orio\Entity;

/**
 * Class Rid
 * @package Orio\Entity
 *
 * @property string $cluster
 * @property string $position
 */
class Rid
{
    public $cluster;
    public $position;

    /**
     * Rid constructor.
     * @param string|null $rid
     * @param integer|null $position
     */
    public function __construct($rid = null, $position = null)
    {
        if ($rid && is_string($rid)) {
            $a = explode(':', $rid);

            if (count($a) == 2) {
                $this->cluster  = (int)$a[0];
                $this->position = (int)$a[1];
            }
        }

        if (is_integer($rid) && is_integer($position)) {
            $this->cluster = $rid;
            $this->position = $position;
        }
    }

    public function __toString()
    {
        return "#{$this->cluster}:{$this->position}";
    }
}