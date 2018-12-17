<?php

namespace Orio\Query\Parameters;

use Orio\Query\Commands\ICommand;

/**
 * Class Projection
 * @package Orio\Query\Parameters
 *
 * @property ICommand[]|string[] $fields
 */
class Projection implements IParameter
{
    private $fields = [];

    /**
     * Projection constructor.
     * @param ICommand[]|string[]|string $fields
     */
    public function __construct($fields)
    {
        if (is_array($fields)) {
            $this->fields = $fields;
        } elseif (is_string($fields)) {
            $this->fields[] = $fields;
        } else {
            throw new \InvalidArgumentException("Cannot add $fields as Projection");
        }
    }

    public function build()
    {
        $sql = '';

        foreach ($this->fields as $field) {
            if (is_string($field)) {
                $sql .= "`$field`";

                if( next( $this->fields ) ) {
                    $sql .= ', ';
                }
            }
        }

        return $sql;
    }

}