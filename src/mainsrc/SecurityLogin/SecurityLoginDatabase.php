<?php

namespace App\SecurityLogin;

use App\App\AbstractMVC\AbstractDatabase;
use App\SecurityLogin\MVC\SecurityLoginModel;
use PDO;

class SecurityLoginDatabase extends AbstractDatabase {

    function getTable()
    {
        return "securitylogin";
    }

    function getModel()
    {
        return SecurityLoginModel::class;
    }

    public function newStayin($userid, $identifier, $securitytoken){
        # setzt einen neuen Stay-Login in die Database
        $table = $this->getTable();
        if (!empty( $this->pdo)){
            $statement =  $this->pdo->prepare("INSERT INTO `$table` (`userid`, `identifier`,`securitytoken`) VALUES (:userid, :identifier, :securitytoken)");
            $statement->execute([
                'userid' => $userid,
                'identifier' => $identifier,
                'securitytoken' => $securitytoken,
            ]);
        }
    }

    function getStayinData($identifier){
        $table = $this->getTable();
        $model = $this->getModel();
        if (!empty( $this->pdo)){
            $stayin =  $this->pdo->prepare("SELECT * FROM `$table` WHERE `identifier` = :identifier");
            $stayin->execute([
                'identifier' => $identifier,
            ]);
            $stayin->setFetchMode(PDO::FETCH_CLASS, $model);
            $stayindata = $stayin->fetch(PDO::FETCH_CLASS);
        }
        return $stayindata;
    }

    public function updateSecurityToken(int $userid, string $securitytoken){
        # updatet einen SecurityToken
        $table = $this->getTable();
        if(!empty($this->pdo)){
            $securityExecute = $this->pdo->prepare("UPDATE `$table` SET `securitytoken` = :securitytoken WHERE `userid` = :userid");
            $securityExecute->execute([
                'userid' => $userid,
                'securitytoken' => $securitytoken,
            ]);
        }
    }

    public function deleteStayindata(int $userid){
        # löscht die stay-in-data wieder aus der Datenbank
        $table = $this->getTable();
        if (!empty( $this->pdo)){
            $statement =  $this->pdo->prepare("DELETE FROM `$table` WHERE `userid` = :userid");
            $statement->execute([
                'userid' => $userid,
            ]);
        }
    }
}