<?php

namespace App\Offers;

use App\App\AbstractMVC\AbstractDatabase;
use App\Offers\MVC\OffersModel;
use PDO;

class OffersDatabase extends AbstractDatabase {

    function getTable()
    {
        return "angebote";
    }

    function getModel()
    {
        return OffersModel::class;
    }

    public function getAllOffers(){
        # gibt alle Angebote aus der Datenbank zurück
        $table = $this->getTable();
        $model = $this->getModel();
        if (!empty($this->pdo)){
            $angeboteExecute =  $this->pdo->prepare("SELECT * FROM `$table`");
            $angeboteExecute->execute();
            $angeboteExecute->setFetchMode(PDO::FETCH_CLASS, $model);
            $angeboteData = $angeboteExecute->fetchAll(PDO::FETCH_CLASS);
        }
        return $angeboteData;
    }

    public function getOpenOffers(int $userid){
        # gibt alle Angebote mit status offen zurück
        $table = $this->getTable();
        $model = $this->getModel();
        if(!empty($this->pdo)){
            $offerExecute = $this->pdo->prepare("SELECT * FROM `$table` WHERE status = 'offen' AND `lehrerid` != :userid");
            $offerExecute->execute([
                "userid" => $userid,
            ]);
            $offerExecute->setFetchMode(PDO::FETCH_CLASS, $model);
            $offerData = $offerExecute->fetchAll(PDO::FETCH_CLASS);
        }
        return $offerData;
    }

    public function getOfferById(int $offerId){
        # gibt ein Angebot an einer bestimmten Id zurück
        $table = $this->getTable();
        $model = $this->getModel();
        if(!empty($this->pdo)){
            $offerExecute = $this->pdo->prepare("SELECT * FROM `$table` WHERE `id` = :offerid");
            $offerExecute->execute([
                'offerid' => $offerId,
            ]);
            $offerExecute->setFetchMode(PDO::FETCH_CLASS, $model);
            $offerData = $offerExecute->fetch(PDO::FETCH_CLASS);
        }
        return $offerData;
    }

    public function getOffersBySubject(String $fach, String $status){
        # gibt alle Angebote mit einem bestimmten Fach und Status zurückk
        $table = $this->getTable();
        $model = $this->getModel();
        if(!empty($this->pdo)){
            $offerExecute = $this->pdo->prepare("SELECT * FROM `$table` WHERE `status` = :status AND `fach` = :fach");
            $offerExecute->execute([
                "status" => $status,
                "fach" => $fach,
            ]);
            $offerExecute->setFetchMode(PDO::FETCH_CLASS, $model);
            $offerData = $offerExecute->fetchAll(PDO::FETCH_CLASS);
        }
        return $offerData;
    }

    public function updateOffer(int $id, string $fach, string $status, string $jahrgang, string $email, string $beschreibung, string $gebuchteUser, string $angefragteUser){
        # Aktualisiert die Attribute eines Angebots anhand seiner ID
        $table = $this->getTable();
        if(!empty($this->pdo)){
            $offerExecute = $this->pdo->prepare("UPDATE `$table` SET `fach` = :fach, `status` = :status, `jahrgang` = :jahrgang, `email` = :email, `beschreibung` = :beschreibung, `gebuchteUser` = :gebuchteUser, `angefragteUser` = :angefragteUser WHERE `id` = :id");
            $offerExecute->execute([
                'id' => $id,
                'fach' => $fach,
                'status' => $status,
                'jahrgang' => $jahrgang,
                'email' => $email,
                'beschreibung' => $beschreibung,
                'gebuchteUser' => $gebuchteUser,
                'angefragteUser' => $angefragteUser,
            ]);
        }
    }

    public function updateOfferBookedUser(int $id, string $gebuchteUser){
        # Aktualisiert die Liste der gebuchten User
        $table = $this->getTable();
        if(!empty($this->pdo)){
            $offerExecute = $this->pdo->prepare("UPDATE `$table` SET `gebuchteUser` = :gebuchteUser WHERE `id` = :id");
            $offerExecute->execute([
                'id' => $id,
                'gebuchteUser' => "$gebuchteUser",
            ]);
        }
    }

    public function updateOfferOpenUser(int $id, string $angefragteUser){
        # Aktualisiert die Liste der User, die Nachhilfe angefragt haben
        $table = $this->getTable();
        if(!empty($this->pdo)){
            $offerExecute = $this->pdo->prepare("UPDATE `$table` SET `angefragteUser` = :angefragteUser WHERE `id` = :id");
            $offerExecute->execute([
                'id' => $id,
                'angefragteUser' => "$angefragteUser",
            ]);
        }
    }

    public function newOffer($lehrer, $lehrerid, $fach, $status, $jahrgang){
        # fügt einen neuen User in die Datenbank ein
        $table = $this->getTable();
        if (!empty( $this->pdo)){
            $statement =  $this->pdo->prepare("INSERT INTO `$table` (`lehrer`, `lehrerid`, `fach`, `status`, `jahrgang`) VALUES (:lehrer, :lehrerid, :fach, :status, :jahrgang)");
            $statement->execute([
                'lehrer' => $lehrer,
                'lehrerid' => $lehrerid,
                'fach' => $fach,
                'status' => $status,
                'jahrgang' => $jahrgang,
            ]);
        }
    }

    public function deleteOfferById(int $id){
        # löscht ein Offer an einer bestimmen ID aus der Datenbank
        $table = $this->getTable();
        if (!empty($this->pdo)){
            $offerExecute =  $this->pdo->prepare("DELETE FROM `$table` WHERE `id` = :id");
            $offerExecute->execute([
                'id' => $id,
            ]);
        }
    }
}