<?php

namespace Orio;

/**
 * Created by PhpStorm.
 * User: egretos
 * Date: 30.12.17
 * Time: 1:46
 */
class Qbuilder
{
    public $action;
    public $actionParams = [];
    public $selectVars = [];

    public $filters = [];

     /**
      * @param $from string
      * @param $properties array
      * @return $this Qbuilder
      */
    public function select($from = 'V', $properties = [])
    {
        $this->action = 'select';
        $this->selectVars = $properties;
        $this->actionParams[] = 'from ' . addslashes($from);
        return $this;
    }

    /**
     * @param $var array|string
     */
    public function addSelectVar($var)
    {
        if (gettype($var) == 'string') {
            $this->selectVars[] = $var;
        } elseif (gettype($var) == 'array') {
            foreach ($var as $item) {
                $this->selectVars[] = $item;
            }
        }
    }

    /**
     * @param $item string
     * @param $operator string
     * @param $item2 string
     * @return $this Qbuilder
     */
    public function addCondition($item, $operator, $item2)
    {
        $this->actionParams[] = 'where ' .
            addslashes($item) . ' ' .
            $operator . ' \'' .
            addslashes($item2) . '\' ';
        return $this;
    }

    /**
     * @return string QueryString
     */
    public function build()
    {
        $ret = $this->action;

        if ($ret == 'select') {
            foreach ($this->selectVars as $var) {
                $ret = $ret . ' ' . $var;
                if ($var !== end($this->selectVars)) {
                    $ret = $ret . ', ';
                } else {
                    $ret = $ret . ' ';
                }
            }
        }

        foreach ($this->actionParams as $name => $value) {
            $ret = $ret . ' ' . $value;
        }
        return $ret . ';';
    }
}
