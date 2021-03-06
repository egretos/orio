<?php

namespace Orio;

use Orio\Query\Builder;
use PhpOrient\PhpOrient;
use PhpOrient\Protocols\Binary\Data\ID;

/**
 * Class DB
 * @var $client PhpOrient
 * @var $settings array
 */

class DB
{
    private $client;
    public  $settings;

    public function __construct($settings = null)
    {
        if ($settings) {
            $this->init($settings);
        }
    }

    /**
     * @return PhpOrient
     */
    public function getClient()
    {
        return $this->client;
    }

    public function init(array $settings)
    {
        $options = [
            'username',
            'password',
            'database',
            'hostname',
            'port',
        ];

        $client = new PhpOrient();

        foreach ($options as $option) {
            if (!key_exists($option, $settings)) {
                throw new \InvalidArgumentException("$option not exists in settings array");
            } else {
                $client->$option = $settings[$option];
            }
        }

        $client->dbOpen($settings['database'], $client->username, $client->password);

        $this->client = $client;
        $this->settings = $settings;
    }


    /**
     * @param $query string
     * @return array
     */
    public function command($query)
    {
        return $this
            ->getClient()
            ->query($query);
    }

    public function query()
    {
        return new Builder();
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
     * @param $rid string|ID
     * @return Model
     */
    public static function byRid($rid)
    {
        $DB = new DB(DB::$settings);

        if (get_class($rid) == 'PhpOrient\Protocols\Binary\Data\ID') {
            $rid = $rid->__toString();
        }

        $DB->qBuilder->select($rid);

        $QueryString = $DB->qBuilder->build();
        $data = DB::command($QueryString);

        $model = new Model();
        $model->writeFromRecord(array_shift($data));

        return $model;
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
     * @param $link string class of edge
     * @param $direction string in|out Direction of Link
     * @return DB
     */
    public function linked($link, $direction = 'out')
    {
        if ($direction == 'out') {
            $param = 'expand(out("' . htmlspecialchars($link) . '"))';
        } else {
            $param = 'expand(in("' . htmlspecialchars($link) . '"))';
        }
        $qb = new Qbuilder();
        $qb
            ->select(substr($this->qBuilder->actionParams['from'], 5))
            ->addSelectVar($param);
        $qb->conditions = $this->qBuilder->conditions;
        $this->qBuilder->conditions = [];

        $param = '('.$qb->build().')';
        $this->qBuilder->select($param);

        return $this;
    }

    /**
     * @param $params []
     * @return array
     */
    public function get($params = 0)
    {
        /*if ($params === 0) {
            $params = ['*', 'in()', 'out()'];
        }*/

        $this->qBuilder->addSelectVar($params);

        $QueryString = $this->qBuilder->build();
        $data = DB::command($QueryString);
        $ret = new ModelArray();
        $ret->fromRecordArray($data);

        return $ret->getArray();
    }

    /**
     * @param $limit int
     * @return DB
     */
    public function limit($limit)
    {
        $this->qBuilder->addFilter('limit', $limit);
        return $this;
    }

    /**
     * @return Model
     */
    public function one()
    {
        $this->qBuilder->addFilter('limit', 1);
        $ret = $this->get()[0];
        return $ret;
    }
}
