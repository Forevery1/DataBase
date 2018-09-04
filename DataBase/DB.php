<?php
/**
 * Created by IntelliJ IDEA.
 * User: Forevery
 * Date: 2018/9/3
 * Time: 23:24
 */

namespace DataBase;

use DataBase\Query\find;
use Database\Query\First;
use Database\Query\Insert;
use Database\Query\Paginate;
use DataBase\Query\Query;
use Database\Query\Update;
use DataBase\Schema\Builder;
use PDO;
use Database\Query\Delete;

ini_set("error_reporting", "E_ALL & ~E_NOTICE");
defined('DB_CONFIG_PATH') or define('DB_CONFIG_PATH', "Define_Forevery");

class DB {

    protected $builder;

    /**
     * @param $table
     * @return DB
     */
    public static function table($table) {
        return new DB($table);
    }

    public function __construct($from) {
        $this->builder = new Builder();
        $load_config = include DB_CONFIG_PATH . "/DataBase.php";
        if (strcmp(DB_CONFIG_PATH, "Define_Forevery") == 0) $load_config = include "Config/Config.php";
        $def_conf = include "Config/Config.php";
        $config = array_merge($def_conf, $load_config);
        print_r($config);
        $connect = "mysql:host=" . $config['hostname'] . ";dbname=" . $config['database'];
        $conf = array(PDO::MYSQL_ATTR_INIT_COMMAND => "set names {$config['charset']}");
        try {
            $this->builder->dbh = new PDO($connect, $config['username'], $config['password'], $conf);;
        } catch (\PDOException $exception) {
            echo "数据库连接失败!";
        }
        // 初始化构造 SQL
        $this->builder->from = $config['prefix'] . $from;
        $this->builder->initBuilder();
    }

    /**
     * @param mixed ...$columns
     * @return DB
     */
    public function select(...$columns) {
        // 重置前一次的
        $this->builder->columns = [];

        foreach ($columns as $param) {
            $this->builder->columns[] = $param;
        }

        return $this;
    }

    /**
     * @param $offset
     * @return DB
     */
    public function offset($offset) {
        $this->builder->offset = $offset;

        return $this;
    }

    /**
     * @param $limit
     * @return DB
     */
    public function limit($limit) {
        $this->builder->limit = $limit;

        return $this;
    }

    /**
     * @param $field
     * @param string $order
     * @return DB
     */
    public function orderBy($field, $order = 'asc') {
        $this->builder->orders[$field] = $order;

        return $this;
    }

    /**
     * @param $column
     * @param null $operator
     * @param null $value
     * @return DB
     */
    public function where($column, $operator = null, $value = null) {
        if (2 === func_num_args()) {
            list($column, $value) = [$column, $operator];
            $operator = '=';
            $type = 'and';
        }

        $this->builder->wheres[] = compact(
            'column', 'operator', 'value', 'type'
        );
        return $this;
    }

    /**
     * @param $column
     * @param null $operator
     * @param null $value
     * @return $this
     */
    public function whereOr($column, $operator = null, $value = null) {
        if (2 === func_num_args()) {
            list($column, $value) = [$column, $operator];
            $operator = '=';
            $type = 'or';
        }

        $this->builder->wheres[] = compact(
            'column', 'operator', 'value', 'type'
        );
        return $this;
    }

    /**
     * @return array
     */
    public function query() {
        return (new Query($this->builder))->build();
    }

    /**
     * @param mixed ...$params
     * @return array
     */
    public function find(...$params) {
        return (new find($this->builder))->build(...$params);
    }

    /**
     * @param mixed ...$params
     * @return bool
     */
    public function insert(...$params) {
        return (new Insert($this->builder))->build(...$params);
    }

    /**
     * @return bool
     */
    public function delete() {
        return (new Delete($this->builder))->build();
    }

    /**
     * @param mixed ...$params
     * @return bool
     */
    public function update(...$params) {
        return (new Update($this->builder))->build(...$params);
    }

    /**
     * @return array
     */
    public function first() {
        return (new First($this->builder))->build();
    }

    /**
     * @param $pagesize
     * @return \Database\Paginates\Page
     */
    public function paginate($pagesize) {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        return (new Paginate($this->builder))->build($pagesize, $page);
    }

}
