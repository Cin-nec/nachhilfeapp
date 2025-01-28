<?php

namespace App\User;

use App\App\AbstractMVC\AbstractDatabase;
use App\User\MVC\UserModel;
use PDO;

class UserDatabase extends AbstractDatabase {

    # liefern den Namen der Datenbank sowie die Fetch Klasse
    function getTable()
    {
        return "user";
    }

    function getModel()
    {
        return UserModel::class;
    }

    public function getAllUsers(){
        # gettet alle User aus der Datenbank und gibt diese zurück
        $table = $this->getTable();
        $model = $this->getModel();
        if (!empty( $this->pdo)){
            $userExecute =  $this->pdo->prepare("SELECT * FROM `$table`");
            $userExecute->execute();
            $userExecute->setFetchMode(PDO::FETCH_CLASS, $model);
            $userData = $userExecute->fetchAll(PDO::FETCH_CLASS);
        }
        return $userData;
    }

    public function getUserById(int $userid){
        # gettet ein User anhand seiner ID und gibt seine betreffenden Informationen zurück
        $table = $this->getTable();
        $model = $this->getModel();
        if(!empty($this->pdo)){
            $userExecute = $this->pdo->prepare("SELECT * FROM `$table` WHERE `userid` = :userid");
            $userExecute->execute([
                'userid' => $userid,
            ]);
            $userExecute->setFetchMode(PDO::FETCH_CLASS, $model);
            $userData = $userExecute->fetch(PDO::FETCH_CLASS);
        }
        return $userData;
    }

    public function getUserByEmail(string $mail){
        # gibt einen User anhand seiner Email-Adresse zurück
        $table = $this->getTable();
        $model = $this->getModel();
        if(!empty($this->pdo)){
            $userExecute = $this->pdo->prepare("SELECT * FROM `$table` WHERE `mail` = :mail");
            $userExecute->execute([
                'mail' => $mail,
            ]);
            $userExecute->setFetchMode(PDO::FETCH_CLASS, $model);
            $userData = $userExecute->fetch(PDO::FETCH_CLASS);
        }
        return $userData;
    }

    public function getUnverifiedUser(string $mail){
        # gibt einen unverifizierten User anhand seiner Email und seinen Aktivierungscode zurück
        $table = $this->getTable();
        $model = $this->getModel();
        if(!empty($this->pdo)){
            $userExecute = $this->pdo->prepare("SELECT * FROM `$table` WHERE `active` = 0 AND `mail` = :mail");
            $userExecute->execute([
                'mail' => $mail,
            ]);
            $userExecute->setFetchMode(PDO::FETCH_CLASS, $model);
            $userData = $userExecute->fetch(PDO::FETCH_CLASS);
        }
        return $userData;
    }

    public function updateUserById($userid, $username, $stufe, $geschlecht, $lieblingsfach){
        # updatet einen User an einer gegebenen ID mit den Werten
        $table = $this->getTable();
        if(!empty($this->pdo)){
            $userExecute = $this->pdo->prepare("UPDATE `$table` SET `username` = :username, `stufe` = :stufe, `geschlecht` = :geschlecht, `lieblingsfach` = :lieblingsfach WHERE `userid` = :userid");
            $userExecute->execute([
                'userid' => $userid,
                'username' => $username,
                'stufe' => $stufe,
                'geschlecht' => $geschlecht,
                'lieblingsfach' => $lieblingsfach,
            ]);
        }
    }

    public function updateUserPasswordById($userid, $password){
        # updatet nur das Password eines Users
        $table = $this->getTable();
        if(!empty($this->pdo)){
            $userExecute = $this->pdo->prepare("UPDATE `$table` SET `password` = :password WHERE `userid` = :userid");
            $userExecute->execute([
                'userid' => $userid,
                'password' => $password,
            ]);
        }
    }

    public function activateUserById($userid){
        # aktiviert einen Account anhand der UserID
        $table = $this->getTable();
        if(!empty($this->pdo)){
            $userExecute = $this->pdo->prepare("UPDATE `$table` SET `active` = :active WHERE `userid` = :userid");
            $userExecute->execute([
                'userid' => $userid,
                'active' => 1,
            ]);
        }
    }

    public function newUser($username, $stufe, $geschlecht, $lieblingsfach, $mail, $password, $activationCode, $activationExpiry){
        # fügt einen neuen User in die Datenbank ein
        $table = $this->getTable();
        if (!empty( $this->pdo)){
            $statement =  $this->pdo->prepare("INSERT INTO `$table` (`mail`, `password`,`username`, `stufe`, `geschlecht`, `lieblingsfach`, `activation_code`, `activation_expiry`) VALUES (:mail, :password, :username, :stufe, :geschlecht, :lieblingsfach, :activation_code, :activation_expiry)");
            $statement->execute([
                'username' => $username,
                'stufe' => $stufe,
                'geschlecht' => $geschlecht,
                'lieblingsfach' => $lieblingsfach,
                'mail' => $mail,
                'password' => $password,
                'activation_code' => $activationCode,
                'activation_expiry' => $activationExpiry
            ]);
        }
    }


    public function deleteUserById(int $userid){
        # löscht einen User an einer bestimmen ID aus der Datenbank
        $table = $this->getTable();
        if (!empty( $this->pdo)){
            $statement =  $this->pdo->prepare("DELETE FROM `$table` WHERE `userid` = :userid");
            $statement->execute([
                'userid' => $userid,
            ]);
        }
    }

}