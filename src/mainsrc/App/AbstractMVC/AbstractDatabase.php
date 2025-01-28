<?php

namespace App\App\AbstractMVC;
use PDO;

abstract class AbstractDatabase{

    protected $pdo;
    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    abstract function getTable();
    abstract function getModel();


    function getUser($userid, $mail){
        $table = $this->getTable();
        $model = $this->getModel();
        if (!empty( $this->pdo)){
            $user =  $this->pdo->prepare("SELECT * FROM `$table` WHERE `userid` = :userid OR `mail` = :mail");
            $user->execute([
                'userid' => $userid,
                'mail' => $mail,
            ]);
            $user->setFetchMode(PDO::FETCH_CLASS, $model);
            $userdata = $user->fetch(PDO::FETCH_CLASS);
        }
        return $userdata;
    }

    function getGuild($guildid){
        $table = $this->getTable();
        $model = $this->getModel();
        if (!empty( $this->pdo)){
            $guild =  $this->pdo->prepare("SELECT * FROM `$table` WHERE `guild_id` = :guild_id");
            $guild->execute([
                'guild_id' => $guildid
            ]);
            $guild->setFetchMode(PDO::FETCH_CLASS, $model);
            $guilddata = $guild->fetch(PDO::FETCH_CLASS);
        }
        return $guilddata;
    }


}