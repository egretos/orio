<?php

namespace Orio;

use PhpOrient\PhpOrient;

/**
 * Class DB
 * @var $client PhpOrient
 * @var $settings array
 */

class DB
{
    private static $client;
    public static $settings;

    /**
     * @var $qBuilder Qbuilder
     */
    private $qBuilder;

    public function __construct($settings)
    {
        $this->qBuilder = new Qbuilder();
    }


    /**
     * @return PhpOrient
     */
    public static function getClient()
    {
        return DB::$client;
    }

    public static function init($settings)
    {

        $client = new PhpOrient();
        $client->username = $settings['username'];
        $client->password = $settings['password'];
        $client->hostname = $settings['hostname'];
        $client->port     = $settings['port'];

        $client->dbOpen($settings['name'], $client->username, $client->password);

        DB::$client = $client;
        DB::$settings = $settings;
    }


    /**
     * @param $query string
     * @return array
     */
    public static function command($query)
    {
        $client = DB::getClient();
        $data = $client->query($query);

        return $data;
    }

    /**
     * @param $class string
     * @return DB
     */
    public static function select($class)
    {
        $DB = new DB(DB::$settings);

        $DB->qBuilder->select($class);

        return $DB;
    }

    /**
     * @param $item1 string
     * @param $item2 | $condition string
     * @return $this DB
     */
    public function where()
    {
        $cnt = func_num_args();
        if ($cnt == 2) {
            $this->qBuilder->addCondition(
                func_get_arg(0),
                '=',
                func_get_arg(1)
            );
        } elseif ($cnt == 3) {
            $this->qBuilder->addCondition(
                func_get_arg(0),
                func_get_arg(1),
                func_get_arg(2)
            );
        }

        return $this;
    }

    /**
     * @return ModelArray
     */
    public function get()
    {
        $QueryString = $this->qBuilder->build();
        $data = DB::command($QueryString);
        $ret = new ModelArray();
        $ret->setArray($data);

        return $ret;
    }
}
