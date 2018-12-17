<?php

namespace Orio\Query\Parameters;

use Orio\Entity\Document;
use Orio\Entity\Rid;

/**
 * Class Target
 * @package Orio\Query\Parameters
 *
 * @property  $target
 */
class Target implements IParameter
{
    private $target;

    /**
     * @param string|Rid|Document|Rid[] $target
     */
    public function __construct($target)
    {
        $this->target = $target;
    }

    public function build()
    {
        if (is_string($this->target)) {
            return "FROM `{$this->target}`";
        } elseif ($this->target instanceof Rid) {
            return "FROM {$this->target}";
        } elseif ($this->target instanceof Document) {
            return "FROM {$this->target->rid}";
        } elseif (is_array($this->target)) {
            $result = 'FROM [';

            foreach ($this->target as $rid) {
                if ($rid instanceof Rid) {
                    $result .= $rid;
                } else {
                    continue;
                }
                if( next( $this->target ) ) {
                    $result .= ', ';
                }
            }
            $result .= ']';

            return $result;
        } else {
            throw new \TypeError('Target must to be string|Rid|Document|Rid[]');
        }
    }
}