<?php
/**
 * Created by IntelliJ IDEA.
 * User: Forevery
 * Date: 2018/9/3
 * Time: 20:21
 */

use DataBase\DB;

require "DataBase/vendor/autoload.php";

//定义配置文件路径
define("DB_CONFIG_PATH", __DIR__ . '/Config');


/**
 *插入
 */
$data = [
    'id' => 1,
    'name' => 'Forevery'
];

DB::table('user')->insert($data);

/**
 * 查询
 */
$result = DB::table('user')
    ->where('id', '>', 0)
    ->query();
print_r($result);

/**
 * 删除
 */
DB::table('user')
    ->where('id', '>', 0)
    ->delete();


/**
 * 更新
 */
$update = [
    'id' => 1,
    'name' => 'Forevery_100'
];

DB::table('user')
    ->where('id', '>', 0)
    ->update($update);

/**
 * 分页
 */
$result = DB::table('user')
    ->where('id', '>', 0)
    ->paginate(5);

print_r($result->data);
echo $result->links();

