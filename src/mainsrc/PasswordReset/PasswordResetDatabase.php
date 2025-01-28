<?php

namespace App\PasswordReset;

use App\App\AbstractMVC\AbstractDatabase;
use App\PasswordReset\MVC\PasswordResetModel;
use PDO;

class PasswordResetDatabase extends AbstractDatabase {

    function getTable()
    {
        return "passwordreset";
    }

    function getModel()
    {
        return PasswordResetModel::class;
    }

    public function newResetCodeEntry(string $mail, $resetCode, $code_expiry){
        # fügt die Email-Adresse, den geheimen Code und das Datum in die Datenbank ein
        $table = $this->getTable();
        if (!empty( $this->pdo)){
            $statement =  $this->pdo->prepare("INSERT INTO `$table` (`mail`, `token`,`code_expiry`) VALUES (:mail, :token, :code_expiry)");
            $statement->execute([
                'mail' => $mail,
                'token' => $resetCode,
                'code_expiry' => $code_expiry,
            ]);
        }
    }

    public function getResetCodeEntryByEmail(string $mail){
        # gibt einen Eintrag anhand der Email-Adresse zurück
        $table = $this->getTable();
        $model = $this->getModel();
        if(!empty($this->pdo)){
            $resetExecute = $this->pdo->prepare("SELECT * FROM `$table` WHERE `mail` = :mail");
            $resetExecute->execute([
                'mail' => $mail,
            ]);
            $resetExecute->setFetchMode(PDO::FETCH_CLASS, $model);
            $resetData = $resetExecute->fetch(PDO::FETCH_CLASS);
        }
        return $resetData;
    }

    public function getResetCodeEntryByEmailAndToken(string $mail, string $token){
        # gibt einen Eintrag anhand der Email-Adresse und des Token zurück
        $table = $this->getTable();
        $model = $this->getModel();
        if(!empty($this->pdo)){
            $resetExecute = $this->pdo->prepare("SELECT * FROM `$table` WHERE `mail` = :mail AND `token` = :token");
            $resetExecute->execute([
                'mail' => $mail,
                'token' => $token,
            ]);
            $resetExecute->setFetchMode(PDO::FETCH_CLASS, $model);
            $resetData = $resetExecute->fetch(PDO::FETCH_CLASS);
        }
        return $resetData;
    }

    public function deleteResetCodeEntryByEmail(string $mail){
        # löscht einen User an einer bestimmen ID aus der Datenbank
        $table = $this->getTable();
        if (!empty( $this->pdo)){
            $statement =  $this->pdo->prepare("DELETE FROM `$table` WHERE `mail` = :mail");
            $statement->execute([
                'mail' => $mail,
            ]);
        }
    }
}