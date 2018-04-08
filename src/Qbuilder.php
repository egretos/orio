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

    public $conditions = [];
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
        $this->actionParams['from'] = 'from ' . $from;
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
        $this->conditions[] = ' where ' .
            addslashes($item) . ' ' .
            $operator . ' "' .
            addslashes($item2) . '"';
        return $this;
    }

    /**
     * @param $filter string
     * @param $value string
     * @return $this QBuilder
     */
    public function addFilter($filter, $value)
    {
        $this->filters[$filter] = $value;
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

        foreach ($this->conditions as $condition) {
            $ret = $ret . $condition;
        }

        foreach ($this->filters as $filter => $value) {
            $ret = $ret . ' ' . $filter . ' ' . $value;
        }

        return $ret;
    }
}
