<?php
/**
 * Created by PhpStorm.
 * User: dicky
 * Date: 2017/10/17
 * Time: 17:36
 */
class DBModel{
    public $dsn = 'mysql:dbname=dydb;host=127.0.0.1';
    public $user = 'root';
    public $password = 'abc.123';
    public $db;
    public function __construct()
    {
        try {
             $this->db = new PDO($this->dsn, $this->user, $this->password);
            $this->execute("SET names utf8");
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

    }

    /**
     * 执行增删改
     * */
    public function execute($sql){

        return $this->db->exec($sql);
    }

    /**
     * 执行查询
     * */
    public function query($sql){
        return $this->db->query($sql);
    }

    /**
     * 获取错误信息
     * */
    public function getError(){
        return $this->db->errorInfo();
    }
}