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
    public $oIn;
    public $oOut;

    /**
     * @param $record Record
     */
    public function WriteFromRecord($record) {
        $this->rid = $record->rid;
        $this->oClass = $record->oClass;
        $this->version = $record->version;

        $this->decodeOData($record->oData);
    }

    public function decodeOData($oData) {
        foreach ($oData as $key => $data) {
            if(substr($key, 0, 3) == 'in_') {
                $item = new Link();
                $item->WriteFromBag($data);
                $this->oIn[] = $item;
            }
            if(substr($key, 0, 4) == 'out_') {
                $item = new Link();
                $item->WriteFromBag($data);
                $this->oOut[] = $item;
            }
        }
    }
}