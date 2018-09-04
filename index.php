<?php
/**
 * Created by IntelliJ IDEA.
 * User: Forevery
 * Date: 2018/9/3
 * Time: 20:21
 */

use DataBase\DB;

require "DataBase/vendor/autoload.php";


define("DB_CONFIG_PATH", __DIR__ . '/Config');


$users = DB::table('course_type')->paginate(1);

echo "<pre>";
var_dump($users->data);
echo "</pre>";

echo "";
echo $users->links();

