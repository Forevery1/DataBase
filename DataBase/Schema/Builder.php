<?php
/**
 * Created by IntelliJ IDEA.
 * User: Forevery
 * Date: 2018/9/3
 * Time: 23:28
 */

namespace DataBase\Schema;


use PDO;

class Builder {

    public $dbh;

    public $primaryKey;

    public $columns;

    public $from;

    public $offset;

    public $limit;

    public $orders;

    public $wheres = [];

    public $binds = [];

    protected $queryMethod = ['insert', 'delete', 'update', 'first', 'get', 'find', 'paginate'];
    protected $convergeMethod = ['count', 'max', 'min', 'sum'];

    public function getPrimaryKey() {
        return $this->primaryKey ?: 'id';
    }

    public function getExecuteResults($sql, $parameters = [], $method = 'query') {
        // 预处理 SQL
        $statement = $this->dbh->prepare($sql);
        // 执行预处理语句
        $statement->execute($parameters);

        // find 多个集合
        if ($method == 'find' && count($parameters) != 1) {
            $method = 'query';
        }

        // 根据操作返回对应的结果
        switch ($method) {
            case 'get':
            case 'query':
                // 获取返回结果集rowCount
                return $statement->fetchAll(PDO::FETCH_ASSOC);
                break;
            case 'first':
            case 'find':
                return $statement->fetch(PDO::FETCH_ASSOC);
                break;
            case 'update':
            case 'delete':
                return $statement->rowCount();
                break;
            case 'insert':
                return $statement->rowCount();
                break;
            case 'count':
            case 'max':
            case 'min':
            case 'sum':
                return $statement->fetch(PDO::FETCH_OBJ);
                break;
            default:
                throw new \PDOException('无效的执行操作');
                break;
        }

    }

    public function limit($limit) {
        $this->limit = $limit;

        return $this;
    }

    public function offset($offset) {
        $this->offset = $offset;

        return $this;
    }

    public function initBuilder() {
        $this->columns = ['*'];
    }

}