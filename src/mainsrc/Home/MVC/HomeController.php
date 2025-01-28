<?php

namespace App\Home\MVC;

use App\App\AbstractMVC\AbstractController;
use App\Logger\LoggerDatabase;
use App\Offers\OffersDatabase;
use App\User\UserDatabase;

class HomeController extends AbstractController {

    public function __construct(UserDatabase $userDatabase, OffersDatabase $offersDatabase, LoggerDatabase $loggerDatabase){
        $this->userDatabase = $userDatabase;
        $this->offersDatabase = $offersDatabase;
        $this->loggerDatabase = $loggerDatabase;
    }

    public function loadHomePage(){
        if(!empty($_SESSION["login"])){
            if(!empty($_POST)){
                if(!empty($_POST["changeView"])){
                    if($_SESSION["userPermission"] == "simple"){
                        $_SESSION["userPermission"] = "teacher";
                    } elseif ($_SESSION["userPermission"] == "teacher"){
                        $_SESSION["userPermission"] = "simple";
                    }
                }
            }
            $offersData = $this->offersDatabase->getAllOffers();
            $userid = $_SESSION["userid"];
            /*$gebuchteAngebote = [];
            if(!empty($_SESSION["gebucht"])){
                var_dump($_SESSION["gebucht"]);
                $gebuchteAngebote = $this->getBestimmteAngebote($offersData, $_SESSION["gebucht"]);
            } */
            $lehrerAngebote = [];
            foreach ($offersData as $item){
                if($item->lehrerid == $userid){
                    $lehrerAngebote[] = $item;
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
            $openOffers = $this->offersDatabase->getOpenOffers(intval($_SESSION["userid"]));
            $angefragteOffer = [];
            foreach ($openOffers as $item){
                $hatUserAngefragt = in_array(strval($_SESSION["userid"]), explode(",", $item->angefragteUser));
                if($hatUserAngefragt){
                    $angefragteOffer[] = $item;
                }
            }
            $lehrerAngebote = array_slice($lehrerAngebote, 0, 3);
            $gebuchteOffer = array_slice($gebuchteOffer, 0, 3);
            $userid = $_SESSION["userid"];
            $notificationsDelivered = $this->loggerDatabase->getLogByReceiverAndStatus($userid, "delivered");
            $notificationsDelivered = array_slice($notificationsDelivered, 0, 3);
            $this->pageload("Home", "home", [
                "angebote" => $offersData,
                "gebuchteAngebote" => $gebuchteOffer,
                "lehrerAngebote" => $lehrerAngebote,
                "angefragteOffer" => $angefragteOffer,
                "logDelivered" => $notificationsDelivered,
            ]);
        } else {
            header("Location: /login");
        }
    }
}