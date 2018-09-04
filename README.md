 PHP数据库工具
===================================  
### 1 . 使用
```php
    <?php

    use DataBase\DB;   //必须引入
    require "DataBase/vendor/autoload.php"; //必须引入

    /**
    * 定义默认配置文件路径
    * 
    */
    define("DB_CONFIG_PATH", __DIR__ . '/Config');

```

### 2 . 默认配置文件说明
```php
    # DataBase.php
    return [
      // 服务器地址
      'hostname' => 'localhost',
      // 数据库名
      'database' => 'database',
      // 数据库用户名
      'username' => 'root',
      // 数据库密码
      'password' => 'root',
      // 数据库表前缀
      'prefix' => '',
      // 数据库编码默认采用utf8
      'charset' => 'utf8'
    ];
    
  1. 定义默认配置文件路径后，在该路径下创建配置文件
  
  2. 配置文件必须为 [ DataBase.php]
  
  3. 需要配置那个字段配置即可
  
```

[查看配置文件DEMO](https://github.com/Forevery1/DataBase/blob/master/Config/DataBase.php)

### 3 . 方法
```php

  1 . 插入
    
    /**
    *
    * $table 表名
    * $data  数据 array
    * 返回 0|1  失败|成功
    */
    DB::table($table)->insert($data)
  
  2 . 查询
    
    /**
    * 查询所有
    * $table 表名
    * 返回 array
    */
    DB::table($table)->query()
    
    /**
    * where条件查询
    * $table 表名
    * $column 字段
    * $operator 运算符
    * $value 值
    * 返回 array
    */
    DB::table($table)
      ->where($column, $operator , $value)
      ->where($column, $value) //默认操作符为 “=”
      ->query()
    
    /**
    * whereOr条件查询
    * $table 表名
    * $column 字段
    * $operator 运算符
    * $value 值
    * 返回 array
    */
    DB::table($table)
      ->where($column, $operator , $value)
      ->whereOr($column, $value)
      ->where($column, $operator , $value)
      ->query()
            
    /**
    * find查询
    * $table 表名
    * $params 参数
    * 返回 array
    */
    DB::table($table)->find($params)  
    
    /**
    * first查询
    * $table 表名
    * 返回第一条数据 array
    */
    DB::table($table)->first()
    
    /**
    * 指定字段查询
    * $table 表名
    * $columns 表字段
    * 返回数据 array
    */
    DB::table($table)
      ->select($columns)
      ->query()
      
  3 . 删除
  
    /**
    * 删除所有 [ 条件删除结合where ]
    * $table 表名
    * 返回 0|1  失败|成功
    */
    DB::table($table)->delete()
    
  4 . 更新
  
    /**
    * $table 表名
    * $data  数据 array
    * 返回 0|1  失败|成功
    */
    DB::table($table)
      ->where($column, $operator , $value)
      ->update($data)
        
  5 . 分页
    
      /**
      * $table 表名
      * $pagesize 每页数量 
      * 返回数据 array
      */
      $data = DB::table($table)
        ->where($column, $operator , $value)
        ->paginate($pagesize) 
        
      数据 ： $data->data
      分页 ： $data->links()
      
```

[查看DEMO](https://github.com/Forevery1/DataBase/blob/master/Deom.php)