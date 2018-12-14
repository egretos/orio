<?php

namespace Orio\Query\Parameters;

interface IParameter
{
    /**
     * @return string
     */
    public function build();
}