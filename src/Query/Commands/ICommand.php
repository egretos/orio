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
    public static function optionalParameters();

    /**
     * @return string[]
     */
    public static function requiredParameters();

    /**
     * @return string[]
     */
    public static function parametersOrder();

    /**
     * @return string
     */
    public function build();
}