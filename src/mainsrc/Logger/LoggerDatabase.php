<?php

namespace App\Logger;

use App\App\AbstractMVC\AbstractDatabase;
use App\Logger\MVC\LoggerModel;
use PDO;

class LoggerDatabase extends AbstractDatabase {

    function getTable()
    {
        return "log";
    }

    function getModel()
    {
        return LoggerModel::class;
    }

    public function getCompleteLog(){
        # gibt alle Log Nachrichten zurück
        $table = $this->getTable();
        $model = $this->getModel();
        if (!empty($this->pdo)){
            $logExecute =  $this->pdo->prepare("SELECT * FROM `$table`");
            $logExecute->execute();
            $logExecute->setFetchMode(PDO::FETCH_CLASS, $model);
            $logData = $logExecute->fetchAll(PDO::FETCH_CLASS);
        }
        return $logData;
    }

    public function getLogByReceiverAndStatus(int $receiver, String $status){
        # gibt alle Log Nachrichten eines bestimmten Empfängers und eines Status zurück
        $table = $this->getTable();
        $model = $this->getModel();
        if(!empty($this->pdo)){
            $logExecute = $this->pdo->prepare("SELECT * FROM `$table` WHERE `receiver` = :receiver AND `status` = :status");
            $logExecute->execute([
                'receiver' => $receiver,
                'status' => $status,
            ]);
            $logExecute->setFetchMode(PDO::FETCH_CLASS, $model);
            $logData = $logExecute->fetchAll(PDO::FETCH_CLASS);
        }
        return $logData;
    }

    public function getLogBySenderAndReceiverAndCategoryAndRelevance(int $sender, int $receiver, String $category, String $relevance){
        # gibt alle Log Nachrichten eines bestimmten Empfängers zurück
        $table = $this->getTable();
        $model = $this->getModel();
        if(!empty($this->pdo)){
            $logExecute = $this->pdo->prepare("SELECT * FROM `$table` WHERE `sender` = :sender AND `receiver` = :receiver AND `category` = :category AND `relevance` = :relevance");
            $logExecute->execute([
                'sender' => $sender,
                'receiver' => $receiver,
                'category' => $category,
                'relevance' => $relevance,
            ]);
            $logExecute->setFetchMode(PDO::FETCH_CLASS, $model);
            $logData = $logExecute->fetch(PDO::FETCH_CLASS);
        }
        return $logData;
    }

    public function updateLogStatusById(int $id, String $status){
        # updatet den Status einer Log Message
        $table = $this->getTable();
        if(!empty($this->pdo)){
            $userExecute = $this->pdo->prepare("UPDATE `$table` SET `status` = :status WHERE `id` = :id");
            $userExecute->execute([
                'id' => $id,
                'status' => $status,
            ]);
        }
    }

    public function updateLogRelevance(int $sender, int $receiver, String $category, String $relevance, String $newRelevance){
        # setzt die akzeptiert - Nachricht bei relevance auf expired
        $table = $this->getTable();
        if(!empty($this->pdo)){
            $logExecute = $this->pdo->prepare("UPDATE `$table` SET `relevance` = :newRelevance WHERE `sender` = :sender AND `receiver` = :receiver AND `category` = :category AND `relevance` = :relevance");
            $logExecute->execute([
                'sender' => $sender,
                'receiver' => $receiver,
                'category' => $category,
                'relevance' => $relevance,
                'newRelevance' => $newRelevance,
            ]);
        }
    }

    public function newLogMessage(int $receiver, int $sender, String $status, String $category, String $contentHeader, String $contentBody, String $contentForm, String $contentMail, String $relevance){
        # fügt eine neue Log Message in die Datenbank ein
        $table = $this->getTable();
        if (!empty( $this->pdo)){
            $statement =  $this->pdo->prepare("INSERT INTO `$table` (`receiver`, `sender`, `status`, `category`, `contentHeader`, `contentBody`, `contentForm`, `contentMail`, `relevance`) VALUES (:receiver, :sender, :status, :category, :contentHeader, :contentBody, :contentForm, :contentMail, :relevance)");
            $statement->execute([
                'receiver' => $receiver,
                'sender' => $sender,
                'status' => $status,
                'category' => $category,
                'contentHeader' => $contentHeader,
                'contentBody' => $contentBody,
                'contentForm' => $contentForm,
                'contentMail' => $contentMail,
                'relevance' => $relevance,
            ]);
        }
    }
}
