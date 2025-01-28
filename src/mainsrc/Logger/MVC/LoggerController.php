<?php

namespace App\Logger\MVC;

use App\App\AbstractMVC\AbstractController;
use App\Logger\LoggerDatabase;

class LoggerController extends AbstractController {

    public function __construct(LoggerDatabase $loggerDatabase){
        $this->loggerDatabase = $loggerDatabase;
    }

    public function loadLoggerPage(){
        if(empty($_SESSION["login"]) && $_SESSION["userPermission"]){
            header("Location: /login");
        } else {
            if(!empty($_POST)){
                if(!empty($_POST["changeView"])){
                    header("Location: /home");
                }

                if(!empty($_POST["notificationRead"])){
                    $logID = $_POST["notificationRead"];
                    $this->loggerDatabase->updateLogStatusById($logID, "read");
                }
            }
            $userid = $_SESSION["userid"];
            $notificationsRead = $this->loggerDatabase->getLogByReceiverAndStatus($userid, "read");
            $notificationsDelivered = $this->loggerDatabase->getLogByReceiverAndStatus($userid, "delivered");
            $this->pageload("Logger", "log", [
                "logRead" => $notificationsRead,
                "logDelivered" => $notificationsDelivered,
            ]);
        }
    }
}