<?php

namespace Orio\Query\Commands;

interface ICommand
{
    /**
     * @return string
     */
    public function getAlias();

    /**
     * @return string[]
     */
    public function optionalParameters();

    /**
     * @return string[]
     */
    public function requiredParameters();

    /**
     * @return string
     */
    public function build();
}