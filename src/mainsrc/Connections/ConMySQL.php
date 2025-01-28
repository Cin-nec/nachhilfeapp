<?php
namespace App\Connections;
use PDO;

class ConMySQL{

    public function conToMySQL1(){
        #Verbindung zur Datenbank aufbauen
        $pdo = new PDO('mysql:host=localhost:3306;dbname=cinnec177700_;charset=utf8','AdminUser','AdminHM67$');
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        return $pdo;
    }
}