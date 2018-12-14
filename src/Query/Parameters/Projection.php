<?php

namespace Orio\Query\Parameters;

class Projection implements IParameter
{
    private $fields = [];

    /**
     * Projection constructor.
     * @param string[] $fields
     */
    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public function build()
    {
        // TODO: Implement build() method.
    }

}