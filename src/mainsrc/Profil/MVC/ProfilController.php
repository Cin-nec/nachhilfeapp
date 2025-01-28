<?php

namespace App\Profil\MVC;

use App\App\AbstractMVC\AbstractController;
use App\Logger\LoggerDatabase;
use App\User\UserDatabase;

class ProfilController extends AbstractController {
    public function __construct(UserDatabase $userDatabase, LoggerDatabase $loggerDatabase){
        $this->userDatabase = $userDatabase;
        $this->loggerDatabase = $loggerDatabase;
    }
    public function loadProfilPage(){
        if(empty($_SESSION["login"])){
            header("Location: /login");
        } else {
            $fail = [
                "name" => "",
                "age" => "",
                "geschlecht" => "",
                "allgemein" => "",
            ];
            $passedValidation = true;
            if(!empty($_POST)){
                $username = "";
                $geschlecht = "";
                $stufe = "";
                if(isset($_POST["username"]) && is_string($_POST["username"]) && !empty($_POST["username"])) {
                    $username = htmlspecialchars($_POST["username"]);
                    $username = trim($username);
                    if(!ctype_alnum($username)){
                        $passedValidation = false;
                        $fail["name"] = "Bitte, keine Sonderzeichen!";
                    }
                } else {
                    $passedValidation = false;
                    $fail["name"] = "Ein Benutzername wäre doch nett";
                }
                if(isset($_POST["geschlecht"]) && is_string($_POST["geschlecht"]) && !empty($_POST["geschlecht"])) {
                    $geschlecht = htmlspecialchars($_POST["geschlecht"]);
                    $geschlecht = trim($geschlecht);
                } else {
                    $passedValidation = false;
                    $fail["geschlecht"] = "Gebe bitte nur zur Übersicht ein Geschlecht an.";
                }
                if(isset($_POST["age"]) && is_string($_POST["age"]) && !empty($_POST["age"])) {
                    $stufe = htmlspecialchars($_POST["age"]);
                    $stufe = trim($stufe);
                } else {
                    $passedValidation = false;
                    $fail["age"] = "Gib deine ungefährer Jahrgangsstufe an.";
                }

                if($passedValidation){
                    $userid = $_SESSION["userid"];

                    $this->userDatabase->updateUserById($userid, $username, $stufe, $geschlecht, "mathe");
                    $_SESSION["username"] = $username;
                    $_SESSION["geschlecht"] = $geschlecht;
                    $_SESSION["stufe"] = $stufe;
                } else {
                    $fail["allgemein"] = "Bitte überprüfe nochmals deine Eingaben!";
                }
            }
            $userid = $_SESSION["userid"];
            $notificationsDelivered = $this->loggerDatabase->getLogByReceiverAndStatus($userid, "delivered");
            $notificationsDelivered = array_slice($notificationsDelivered, 0, 3);
            $this->pageload("Profil", "profil", [
                "logDelivered" => $notificationsDelivered,
                "fail" => $fail,
            ]);
        }
    }
}