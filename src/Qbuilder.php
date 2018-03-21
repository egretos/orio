<?php

namespace orio;

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

    public $filters = [];

     /**
      * @param $from string
      * @param $properties array
      * @return $this Qbuilder
      */
    public function select($from = 'V', $properties = []) {
        $this->action = 'select';
        $this->actionParams[] = 'from ' . addslashes($from);
        return $this;
    }

    /**
     * @param $item string
     * @param $operator string
     * @param $item2 string
     * @return $this Qbuilder
     */
    public function addCondition($item, $operator, $item2) {
        $this->actionParams[] = 'where ' .
            addslashes($item) . ' ' .
            $operator . ' \'' .
            addslashes($item2) . '\' ';
        return $this;
    }

    /**
     * @return string QueryString
     */
    public function build() {
        $ret = $this->action;
        foreach ($this->actionParams as $name => $value) {
            $ret = $ret . ' ' . $value;
        }
        return $ret . ';';
    }
}