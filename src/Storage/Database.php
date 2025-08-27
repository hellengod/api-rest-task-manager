<?php
namespace App\Storage;

class Database{

    public static function connect(){
        $pdo = new \PDO('mysql:host=localhost;dbname=task_manager', 'root', 'root');
        return $pdo;
    }

}