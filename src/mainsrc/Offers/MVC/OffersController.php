<?php

namespace App\Offers\MVC;

use App\App\AbstractMVC\AbstractController;
use App\Logger\LoggerDatabase;
use App\Offers\OffersDatabase;
use App\User\UserDatabase;

class OffersController extends AbstractController {

    public function __construct(OffersDatabase $offersDatabase, UserDatabase $userDatabase, LoggerDatabase $loggerDatabase){
        $this->offersDatabase = $offersDatabase;
        $this->userDatabase = $userDatabase;
        $this->loggerDatabase = $loggerDatabase;
    }

    public function loadOwnOffersPage(){
        if(empty($_SESSION["login"])){
            header("Location: /login");
        } else {
            $fail = [
                "fach" => "",
                "status" => "",
                "alter" => "",
                "allgemein" => "",
            ];
            $passedValidation = true;
            $filterFach = "";
            if(!empty($_POST)){
                $fach = "";
                $status = "";
                $age = "";
                $result = "";
                if(isset($_POST["submit"])){
                    if(isset($_POST["fach"]) && !empty($_POST["fach"]) && is_string($_POST["fach"])){
                        $fach = htmlspecialchars($_POST["fach"]);
                    } else {
                        $fail["fach"] = "Bitte wähle ein Fach aus.";
                        $passedValidation = false;
                    }
                    if(isset($_POST["angebot--status"]) && !empty($_POST["angebot--status"]) && is_string($_POST["angebot--status"])){
                        $status = htmlspecialchars($_POST["angebot--status"]);
                    } else {
                        $fail["status"] = "Setzte einen vorläufigen Status.";
                        $passedValidation = false;
                    }
                    if(isset($_POST["alter"]) && !empty($_POST["alter"])){
                        $jahrgang = $_POST["alter"];
                        $result = $this->getJahrgangResult($jahrgang);
                    } else {
                        $fail["alter"] = "Wähle die passenden Altersstufen.";
                        $passedValidation = false;
                    }

                    if($passedValidation){
                        $lehrer = $_SESSION["username"];
                        $lehrerid = $_SESSION["userid"];
                        $this->offersDatabase->newOffer($lehrer, $lehrerid,  $fach, $status, $result);
                    } else {
                        $fail["allgemein"] = "Prüfe nochmals deine Eingaben.";
                    }
                }
                if(!empty($_POST["changeView"])){
                    if($_SESSION["userPermission"] == "teacher"){
                        $_SESSION["userPermission"] = "simple";
                        header("Location: /home");
                    }
                }
                if(!empty($_POST["fachFilter"])){
                    $filterFach = $_POST["fachFilter"];
                }
            }
            $offersData = $this->offersDatabase->getAllOffers();
            $lehrerAngebote = [];
            foreach ($offersData as $item){
                if($item->lehrerid == $_SESSION["userid"]){
                    $lehrerAngebote[] = $item;
                }
            }
            $errorFach = "";
            $filteredOffers = [];
            if(!empty($filterFach)){
                foreach ($lehrerAngebote as $item){
                    if($item->fach == $filterFach){
                        $filteredOffers[] = $item;
                    }
                }
                $errorFach = $filterFach;
                $lehrerAngebote = $filteredOffers;
            }
            $userid = $_SESSION["userid"];
            $notificationsDelivered = $this->loggerDatabase->getLogByReceiverAndStatus($userid, "delivered");
            $notificationsDelivered = array_slice($notificationsDelivered, 0, 3);
            $this->pageload("Offers", "ownOffers", [
                "lehrerAngebote" => $lehrerAngebote,
                "logDelivered" => $notificationsDelivered,
                "errorFach" => $errorFach,
                "fail" => $fail,
            ]);
        }
    }
    /*
     * veraltete Funktion für den Notfall, dass noch nicht alles funktioniert.
     * Sobald die Datei offers.php nicht mehr benötigt wird, bitte löschen
    public function loadOwnOffersPage(){
        if(empty($_SESSION["login"]) && $_SESSION["userPermission"] != "teacher"){
            header("Location: /login");
        } else {
            $allOffers = $this->offersDatabase->getAllOffers();
            $result = $this->getBestimmteAngebote($allOffers, $_SESSION["erstellt"]);
            $this->pageload("Offers", "ownOffers", [
                "erstellteAngebote" => $result,
            ]);
        }
    }
     */

    public function loadDetailOwnOffersPage(){
        if(empty($_SESSION["login"])){
            header("Location: /login");
        } else {
            $angebotsid = intval($_GET["id"]);
            $angebot = $this->offersDatabase->getOfferById($angebotsid);
            $fail = [
                "email" => "",
                "beschreibung" => "",
            ];
            if(!empty($_POST)){
                $userAnfragenIDs = explode(",", $angebot->angefragteUser);
                $userGebuchteIDs = explode(",", $angebot->gebuchteUser);
                if(!empty($_POST["changeView"])){
                    if($_SESSION["userPermission"] == "teacher"){
                        $_SESSION["userPermission"] = "simple";
                        header("Location: /home");
                    }
                }
                if(!empty($_POST["teilnehmerAnnehmen"])){
                    $newUserID = $_POST["teilnehmerAnnehmen"];
                    $key = array_search(strval($newUserID), $userAnfragenIDs);
                    unset($userAnfragenIDs[$key]);
                    $userAnfragenIDs = array_values($userAnfragenIDs);
                    $userGebuchteIDs[] = strval($newUserID);
                    $this->loggerDatabase->newLogMessage($newUserID, $angebotsid, "delivered", "akzeptiert", $_SESSION["username"], $angebot->fach, $angebot->beschreibung, $angebot->email, "active");
                } elseif (!empty($_POST["teilnehmerAblehnen"])){
                    $newUserID = $_POST["teilnehmerAblehnen"];
                    $key = array_search(strval($newUserID), $userAnfragenIDs);
                    unset($userAnfragenIDs[$key]);
                    $userAnfragenIDs = array_values($userAnfragenIDs);
                    $this->loggerDatabase->newLogMessage($newUserID, $angebotsid, "delivered", "abgelehnt", $_SESSION["username"], $angebot->fach, "", "", "");
                }
                if(!empty($_POST["teilnehmerEntfernen"])){
                    $deleteUserID = $_POST["teilnehmerEntfernen"];
                    $key = array_search(strval($deleteUserID), $userGebuchteIDs);
                    unset($userGebuchteIDs[$key]);
                    $userGebuchteIDs = array_values($userGebuchteIDs);
                    $this->loggerDatabase->newLogMessage($deleteUserID, $angebotsid, "delivered", "beendet", $_SESSION["username"], $angebot->fach, "", "", "");
                    $this->loggerDatabase->updateLogRelevance($angebotsid, $_SESSION["userid"], "akzeptiert", "active", "expired");
                }
                $userAnfragenIDs = implode(",", $userAnfragenIDs);
                $userGebuchteIDs = implode(",", $userGebuchteIDs);
                if($_POST["deleteBefehl"] == "delete"){
                    $this->offersDatabase->deleteOfferById($angebotsid);
                    header("Location: /home");
                }
                # Angebot Bearbeiten Formular Validation:
                $fach = (empty($_POST["fach"])) ? $angebot["fach"] : $_POST["fach"];
                $fach = htmlspecialchars($fach);
                $status = (empty($_POST["status"])) ? $angebot["status"] : $_POST["status"];
                $status = htmlspecialchars($status);
                $jahrgang = $_POST["alter"];
                if(!empty($jahrgang)){
                    $result = $this->getJahrgangResult($jahrgang);
                } else {
                    $result = $angebot["jahrgang"];
                }
                if(isset($_POST["email"]) && !empty($_POST["email"]) && is_string($_POST["email"])){
                    $email = htmlspecialchars($_POST["email"]);
                } else {
                    $email = $angebot["email"];
                    $fail["email"] = "Deine Eingabe wahr Fehlerhaft";
                }
                if(isset($_POST["beschreibung"]) && !empty($_POST["beschreibung"]) && is_string($_POST["beschreibung"])){
                    $beschreibung = htmlspecialchars($_POST["beschreibung"]);
                } else {
                    $beschreibung = $angebot["beschreibung"];
                    $fail["beschreibung"] = "Deine Eingabe wahr Fehlerhaft";
                }
                $this->offersDatabase->updateOffer($angebotsid, $fach, $status, $result, $email, $beschreibung, $userGebuchteIDs, $userAnfragenIDs);
            }
            $angebot = $this->offersDatabase->getOfferById($angebotsid);
            $userAnfragenIDs = explode(",", $angebot->angefragteUser);
            $userAnfragen = [];
            foreach ($userAnfragenIDs as $item) {
                $userAnfragen[] = $this->userDatabase->getUserById(intval($item));
            }
            $userGebuchteIDs = explode(",", $angebot->gebuchteUser);
            $userGebucht = [];
            foreach ($userGebuchteIDs as $item){
                $userGebucht[] = $this->userDatabase->getUserById(intval($item));
            }
            $userid = $_SESSION["userid"];
            $notificationsDelivered = $this->loggerDatabase->getLogByReceiverAndStatus($userid, "delivered");
            $notificationsDelivered = array_slice($notificationsDelivered, 0, 3);
            $this->pageload("Offers", "ownOffersDetails", [
                "userid" => $userid,
                "angebot" => $angebot,
                "userAnfragen" => $userAnfragen,
                "gebuchteUser" => $userGebucht,
                "logDelivered" => $notificationsDelivered,
                "fail" => $fail,
            ]);
        }
    }

    public function loadBookedOffersPage(){
        if(empty($_SESSION["login"])){
            header("Location: /login");
        } else {
            $filterFach = "";
            if(!empty($_POST)){
                if(!empty($_POST["changeView"])){
                    if($_SESSION["userPermission"] == "simple"){
                        $_SESSION["userPermission"] = "teacher";
                        header("Location: /home");
                    }
                }

                if(!empty($_POST["fach"])){
                    $filterFach = $_POST["fach"];
                }
            }
            $openOffers = $this->offersDatabase->getOpenOffers(intval($_SESSION["userid"]));
            $gebuchteOffer = [];
            foreach ($openOffers as $item){
                $hatUserGebucht = in_array(strval($_SESSION["userid"]), explode(",", $item->gebuchteUser));
                if($hatUserGebucht){
                    $gebuchteOffer[] = $item;
                }
            }
            $errorFach = "";
            $filteredOffers = [];
            if(!empty($filterFach)){
                foreach ($gebuchteOffer as $item){
                    if($item->fach == $filterFach){
                        $filteredOffers[] = $item;
                    }
                }
                $errorFach = $filterFach;
                $gebuchteOffer = $filteredOffers;
            }
            $userid = $_SESSION["userid"];
            $notificationsDelivered = $this->loggerDatabase->getLogByReceiverAndStatus($userid, "delivered");
            $notificationsDelivered = array_slice($notificationsDelivered, 0, 3);
            $this->pageload("Offers", "bookedOffers", [
                "gebuchteAngebote" => $gebuchteOffer,
                "logDelivered" => $notificationsDelivered,
                "errorFach" => $errorFach,
            ]);
        }
    }

    public function loadDetailBookedOffersPage(){
        if(empty($_SESSION["login"])){
            header("Location: /login");
        } else {
            if(!empty($_POST)){
                if(!empty($_POST["changeView"])){
                    if($_SESSION["userPermission"] == "simple"){
                        $_SESSION["userPermission"] = "teacher";
                        header("Location: /home");
                    }
                }
                if(!empty($_POST["nachhilfeBeenden"])){
                    $userid = $_SESSION["userid"];
                    $angebotsid = intval($_GET["id"]);
                    $angebot = $this->offersDatabase->getOfferById($angebotsid);
                    $userGebuchteIDs = explode(",", $angebot->gebuchteUser);
                    $key = array_search(strval($userid), $userGebuchteIDs);
                    unset($userGebuchteIDs[$key]);
                    $userGebuchteIDs = array_values($userGebuchteIDs);
                    $userGebuchteIDs = implode(",", $userGebuchteIDs);
                    $this->offersDatabase->updateOfferBookedUser($angebotsid, $userGebuchteIDs);
                    $this->loggerDatabase->newLogMessage($userid, $angebotsid, "delivered", "beendet", $angebot->lehrer, $angebot->fach, "", "", "");
                    $this->loggerDatabase->updateLogRelevance($angebotsid, $userid, "akzeptiert", "active", "expired");
                    header("Location: /angeboteGebucht");
                }
            }

            #lehrer für das profil
            $angebotsid = intval($_GET["id"]);
            $angebot = $this->offersDatabase->getOfferById($angebotsid);
            $lehrerid = $angebot->lehrerid;
            $lehrer = $this->userDatabase->getUserById(intval($lehrerid));

            # Log Nachrichten für das Popup
            $userid = $_SESSION["userid"];
            $notificationsDelivered = $this->loggerDatabase->getLogByReceiverAndStatus($userid, "delivered");
            $notificationsDelivered = array_slice($notificationsDelivered, 0, 3);

            #Kontaktdaten für den Kontakt-Abschnitt, also Email + Beschreibung aus der entsprechenden akzeptiert - Log Nachricht
            $logDescriptionMail = $this->loggerDatabase->getLogBySenderAndReceiverAndCategoryAndRelevance($angebotsid, $userid, "akzeptiert", "active");
            $this->pageload("Offers", "bookedOffersDetails", [
                "angebot" => $angebot,
                "lehrer" => $lehrer,
                "logDelivered" => $notificationsDelivered,
                "logDescriptionMail" => $logDescriptionMail,
            ]);
        }
    }

    public function loadOpenOffersPage(){
        if(empty($_SESSION["login"])){
            header("Location: /login");
        } else {
            $filterFach = "";
            if(!empty($_POST)){
                if(!empty($_POST["changeView"])){
                    if($_SESSION["userPermission"] == "simple"){
                        $_SESSION["userPermission"] = "teacher";
                        header("Location: /home");
                    }
                }
                if(!empty($_POST["fach"])){
                    $filterFach = $_POST["fach"];
                }
            }
            $openOffers = $this->offersDatabase->getOpenOffers(intval($_SESSION["userid"]));
            $offersData = [];
            foreach ($openOffers as $item){
                $hatUserGebucht = in_array(strval($_SESSION["userid"]), explode(",", $item->gebuchteUser));
                $hatUserAngefragt = in_array(strval($_SESSION["userid"]), explode(",", $item->angefragteUser));
                if(!($hatUserAngefragt or $hatUserGebucht)){
                    $offersData[] = $item;
                }
            }
            $errorFach = "";
            $filteredOffers = [];
            if(!empty($filterFach)){
                foreach ($offersData as $item){
                    if($item->fach == $filterFach){
                        $filteredOffers[] = $item;
                    }
                }
                $errorFach = $filterFach;
                $offersData = $filteredOffers;
            }
            $userid = $_SESSION["userid"];
            $notificationsDelivered = $this->loggerDatabase->getLogByReceiverAndStatus($userid, "delivered");
            $notificationsDelivered = array_slice($notificationsDelivered, 0, 3);
            $this->pageload("Offers", "openOffers", [
                "offersData" => $offersData,
                "logDelivered" => $notificationsDelivered,
                "errorFach" => $errorFach,
            ]);
        }
    }

    public function loadDetailOpenOffersPage(){
        if(empty($_SESSION["login"])){
            header("Location: /login");
        } else {
            if(!empty($_POST)){
                if(!empty($_POST["changeView"])){
                    if($_SESSION["userPermission"] == "simple"){
                        $_SESSION["userPermission"] = "teacher";
                        header("Location: /home");
                    }
                }
                if(!empty($_POST["anfragenBefehl"])){
                    $userid = $_SESSION["userid"];
                    $angebotsid = intval($_GET["id"]);
                    $angebot = $this->offersDatabase->getOfferById($angebotsid);
                    $userAngefragteIDs = explode(",", $angebot->angefragteUser);
                    if(empty($userAngefragteIDs[0])){
                        $userAngefragteIDs[0] = strval($userid);
                    } else {
                        $userAngefragteIDs[] = strval($userid);
                    }
                    $userAngefragteIDs = implode(",", $userAngefragteIDs);
                    $this->offersDatabase->updateOfferOpenUser($angebotsid, $userAngefragteIDs);
                    $this->loggerDatabase->newLogMessage($angebot->lehrerid, $angebotsid, "delivered", "angefragt", $_SESSION["username"], $angebot->fach, $angebot->beschreibung, $angebot->email, "");
                    header("Location: /angeboteOffen");
                }
            }
            $angebotsid = intval($_GET["id"]);
            $angebot = $this->offersDatabase->getOfferById($angebotsid);
            $lehrerid = $angebot->lehrerid;
            $lehrer = $this->userDatabase->getUserById(intval($lehrerid));
            $userid = $_SESSION["userid"];
            $notificationsDelivered = $this->loggerDatabase->getLogByReceiverAndStatus($userid, "delivered");
            $notificationsDelivered = array_slice($notificationsDelivered, 0, 3);
            $this->pageload("Offers", "openOffersDetails", [
                "angebot" => $angebot,
                "logDelivered" => $notificationsDelivered,
                "lehrer" => $lehrer,
            ]);
        }
    }

    public function loadRequestOffersPage(){
        if(empty($_SESSION["login"])){
            header("Location: /login");
        } else {
            $filterFach = "";
            if(!empty($_POST)){
                if(!empty($_POST["changeView"])){
                    if($_SESSION["userPermission"] == "simple"){
                        $_SESSION["userPermission"] = "teacher";
                        header("Location: /home");
                    }
                }

                if(!empty($_POST["fach"])){
                    $filterFach = $_POST["fach"];
                }
            }
            $openOffers = $this->offersDatabase->getOpenOffers(intval($_SESSION["userid"]));
            $offersData = [];
            foreach ($openOffers as $item){
                $hatUserAngefragt = in_array(strval($_SESSION["userid"]), explode(",", $item->angefragteUser));
                if($hatUserAngefragt){
                    $offersData[] = $item;
                }
            }
            $errorFach = "";
            $filteredOffers = [];
            if(!empty($filterFach)){
                foreach ($offersData as $item){
                    if($item->fach == $filterFach){
                        $filteredOffers[] = $item;
                    }
                }
                $errorFach = $filterFach;
                $offersData = $filteredOffers;
            }

            $userid = $_SESSION["userid"];
            $notificationsDelivered = $this->loggerDatabase->getLogByReceiverAndStatus($userid, "delivered");
            $notificationsDelivered = array_slice($notificationsDelivered, 0, 3);
            $this->pageload("Offers", "requestOffers", [
                "offersData" => $offersData,
                "logDelivered" => $notificationsDelivered,
                "errorFach" => $errorFach,
            ]);
        }
    }

    public function loadDetailRequestOffersPage(){
        if(empty($_SESSION["login"])){
            header("Location: /login");
        } else {
            if(!empty($_POST)){
                if(!empty($_POST["changeView"])){
                    if($_SESSION["userPermission"] == "simple"){
                        $_SESSION["userPermission"] = "teacher";
                        header("Location: /home");
                    }
                }
                if(!empty($_POST["anfrageAbbrechen"])){
                    $userid = $_SESSION["userid"];
                    $angebotsid = intval($_GET["id"]);
                    $angebot = $this->offersDatabase->getOfferById($angebotsid);
                    $userAngefragteIDs = explode(",", $angebot->angefragteUser);
                    $key = array_search(strval($userid), $userAngefragteIDs);
                    unset($userAngefragteIDs[$key]);
                    $userAngefragteIDs = array_values($userAngefragteIDs);
                    $userAngefragteIDs = implode(",", $userAngefragteIDs);
                    $this->offersDatabase->updateOfferOpenUser($angebotsid, $userAngefragteIDs);
                    header("Location: /angeboteAngefragt");
                }
            }
            $angebotsid = intval($_GET["id"]);
            $angebot = $this->offersDatabase->getOfferById($angebotsid);
            $lehrerid = $angebot->lehrerid;
            $lehrer = $this->userDatabase->getUserById(intval($lehrerid));
            $userid = $_SESSION["userid"];
            $notificationsDelivered = $this->loggerDatabase->getLogByReceiverAndStatus($userid, "delivered");
            $notificationsDelivered = array_slice($notificationsDelivered, 0, 3);
            $this->pageload("Offers", "requestOffersDetails", [
                "angebot" => $angebot,
                "lehrer" => $lehrer,
                "logDelivered" => $notificationsDelivered,
            ]);
        }
    }

    /**
     * @param mixed $jahrgang
     * @return mixed|string
     */
    public function getJahrgangResult(mixed $jahrgang): mixed
    {
        if (count($jahrgang) == 1) {
            $result = $jahrgang[0];
        } else {
            $result = $jahrgang[0];
            for ($i = 1; $i < (count($jahrgang) - 1); $i++) {
                $result = $result . "," . $jahrgang[$i];
            }
            $result = $result . "," . $jahrgang[(count($jahrgang) - 1)];
        }
        return $result;
    }

    /** ToDo
     *loadDetailBookedOffersPage
     *loadOpenOffersPage
     *loadDetailOffersPage
     */
}