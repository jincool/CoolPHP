<?php
/**
 * Created by PhpStorm.
 * User: Jincool
 * Date: 2018/8/24
 * Time: 10:55
 */

class Model
{

    private static $link = null;//数据库连接

    /**
     * 私有的构造方法
     */
    private function __construct()
    {
    }

    /**
     * 连接数据库
     * @return obj 资源对象
     */
    public static function conn($jb = 'localhost')
    {
        if (self::$link === null) {
            $cfg = require './config/database.php';
            self::$link = new Mysqli($cfg[$jb]['host'], $cfg[$jb]['user'], $cfg[$jb]['pwd'], $cfg[$jb]['db']);

            self::query("set names 'utf8'");//设置字符集
        }
        return self::$link;
    }

    /**
     * 执行一条sql语句
     * @param  str $sql 查询语句
     * @return obj      结果集对象
     */
    public static function query($sql)
    {
        return self::conn()->query($sql);
    }

    /**
     * 获取多行数据
     * @param  str $sql 查询语句
     * @return arr      多行数据
     */
    public static function getAll($sql)
    {
        $data = array();
        $res = self::query($sql);
        while ($row = $res->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    /**
     * 获取一行数据
     * @param  str $sql 查询语句
     * @return arr      单行数据
     */
    public static function getRow($sql)
    {
        $res = self::query($sql);
        return $res->fetch_assoc();
    }

    /**
     * 获取单个结果
     * @param  str $sql 查询语句
     * @return str      单个结果
     */
    public static function getOne($sql)
    {
        $res = self::query($sql);
        $data = $res->fetch_row();
        return $data[0];
    }

    /**
     * 插入/更新数据
     * @param  str $table 表名
     * @param  arr $data 插入/更新的数据
     * @param  str $act insert/update
     * @param  str $where 更新条件
     * @return bool 插入/更新是否成功
     */
    public static function exec($table, $data, $act = 'insert', $where = '0')
    {
        //插入操作
        if ($act == 'insert') {
            $sql = 'insert into ' . $table;
            $sql .= ' (' . implode(',', array_keys($data)) . ')';
            $sql .= " values ('" . implode("','", array_values($data)) . "')";
        } else if ($act == 'update') {
            $sql = 'update ' . $table . ' set ';
            foreach ($data as $k => $v) {
                $sql .= '`'.$k . '`=' . "'$v',";
            }
            $sql = rtrim($sql, ',');
            $sql .= ' where 1 and ' . $where;
        }
        return self::query($sql);
    }

    /**
     * 插入多条二维数组
     * @param $data //二维数组
     * @param $table
     * @return bool 插入是否成功
     */
    public static function insert($data, $table)
    {
        if (!empty($data)) {
            $arr = array();
            foreach ($data as $k => $v) {
                $arr[] = "'" .implode("','", array_values($data[$k]))."'";
            }
            $sql = 'insert into ' . $table;
            $sql .= ' (' . implode(',', array_keys($data[0])) . ') values';
            foreach ($data as $k => $v) {
                $sql .= " ($arr[$k]) ,";
            }
            $insertSql = rtrim($sql, ",");
            return self::query($insertSql);
        }
    }

    /**
     * 获取最近一次插入的主键值
     * @return int 主键
     */
    public static function getLastId()
    {
        return self::conn()->insert_id;
    }

    /**
     * 获取最近一次操作影响的行数
     * @return int 影响的行数
     */
    public static function getAffectedRows()
    {
        return self::conn()->affected_rows;
    }

    /**
     * 关闭数据库连接
     * @return bool 是否关闭
     */
    public static function close()
    {
        return self::conn()->close();
    }


}
