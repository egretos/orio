<?php

namespace Orio;

use \PhpOrient\Protocols\Binary\Data\Record;

/**
 * Class Model
 * @var $rid string
 * @var $class string
 */
class Model extends Record
{
    /**
     * @var $in array
     * @var $out array
     */
    public $in;
    public $out;

    /**
     * @param $record Record
     */
    public function writeFromRecord($record)
    {
        $this->rid = $record->rid;
        $this->oClass = $record->oClass;
        $this->version = $record->version;

        $this->decodeOData($record->oData);
    }

    public function decodeOData($oData)
    {
        foreach ($oData as $key => $data) {
            if (substr($key, 0, 3) == 'in_') {
                $item = new Link();
                $item->writeFromBag($data);
                $item->class = substr($key, 3);
                $this->in[$item->class] = $item;
            } elseif (substr($key, 0, 4) == 'out_') {
                $item = new Link();
                $item->writeFromBag($data);
                $item->class = substr($key, 4);
                $this->out[$item->class] = $item;
            } else {
                $this->$key = $data;
            }
        }
    }
}
