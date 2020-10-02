<?php
namespace libs;

use PDO;
header('content-type:text/html;charset=utf8');
class Db
{
    protected $pdo;

    // public function __construct()
    // {
        
    //     $dsn = 'mysql:dbname=coding;host=127.0.0.1;port=3308';
    //     $this->pdo = new PDO($dsn, 'root', '');
    //    //$dsn='mysql:host=127.0.0.1;dbname=homeuser;port=3308';
    //     //$pdo=new PDO($dsn, 'root', '');
    //     //设置字符集为utf8
    //     //$pdo->query('set names utf8');
    // }

    
    // protected function prepare($sql, $args = [])
    // {
    //     $stmt = $this->pdo->prepare($sql);
    //     $suc = $stmt->execute($args);

    //     if (!$suc) {
    //         echo '<pre>';
    //         print_r($stmt->errorInfo());
    //         print_r($args);
    //         echo '</pre>';
    //         die($sql);
    //     }

    //     return $stmt;
    // }

    
    public function exec($sql, $args = [])
    {
         $dsn = 'mysql:dbname=coding;host=127.0.0.1;port=3308';
         $pdo = new PDO($dsn, 'root', '');
         $pdo->query('set names utf8');
         $stmt = $pdo->prepare($sql);
         $suc = $stmt->execute($args);

         if (!$suc) {
             echo '<pre>';
             print_r($stmt->errorInfo());
             print_r($args);
             echo '</pre>';
             die($sql);
       }

       
        return $stmt->rowCount();
    }
    public function version()
    {
       // return $this->pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
    }


   
    public function fetch($sql, $args = [])
    {
         $dsn = 'mysql:dbname=coding;host=127.0.0.1;port=3308';
         $pdo = new PDO($dsn, 'root', '');
         $pdo->query('set names utf8');
         $stmt = $pdo->prepare($sql);
         $suc = $stmt->execute($args);

         if (!$suc) {
             echo '<pre>';
             print_r($stmt->errorInfo());
             print_r($args);
             echo '</pre>';
             die($sql);
         }

        //
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    public function fetchAll($sql, $args = [])
    {
         $dsn = 'mysql:dbname=coding;host=127.0.0.1;port=3308';
         $pdo = new PDO($dsn, 'root', '');
         $pdo->query('set names utf8');
         $stmt = $pdo->prepare($sql);
         $suc = $stmt->execute($args);

        if (!$suc) {
            echo '<pre>';
             print_r($stmt->errorInfo());
             print_r($args);
             echo '</pre>';
            die($sql);
         }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
