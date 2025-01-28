<?php

namespace App\Server;

use App\App\AbstractMVC\AbstractDatabase;
use App\Server\MVC\ServerModel;
use PDO;

class ServerDatabase extends AbstractDatabase {

    function getTable()
    {
        return "guilds";
    }

    function getModel()
    {
        return ServerModel::class;
    }

    function getGuildIDs(){
        $table = $this->getTable();
        $model = $this->getModel();
        if (!empty( $this->pdo)){
            $guilds =  $this->pdo->prepare("SELECT * FROM `$table`");
            $guilds->execute();
            $guilds->setFetchMode(PDO::FETCH_CLASS, $model);
            $guildsdata = $guilds->fetchAll(PDO::FETCH_CLASS);
        }
        return $guildsdata;
    }

    function getChannels($guildid){
        $table = $this->getTable();
        $model = $this->getModel();
        if (!empty( $this->pdo)){
            $channel =  $this->pdo->prepare("SELECT * FROM `$table` WHERE `guild_id` = :guildid");
            $channel->execute([
                'guildid' => $guildid
            ]);
            $channel->setFetchMode(PDO::FETCH_CLASS, $model);
            $guilddata = $channel->fetch(PDO::FETCH_CLASS);
        }
        return $guilddata;
    }

    function getRoles($guildid){
        $table = $this->getTable();
        $model = $this->getModel();
        if (!empty( $this->pdo)){
            $roles =  $this->pdo->prepare("SELECT * FROM `$table` WHERE `guild_id` = :guildid");
            $roles->execute([
                'guildid' => $guildid
            ]);
            $roles->setFetchMode(PDO::FETCH_CLASS, $model);
            $roledata = $roles->fetch(PDO::FETCH_CLASS);
        }
        return $roledata;
    }


}