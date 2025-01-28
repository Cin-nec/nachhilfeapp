<?php

namespace App\Login\MVC;

use App\App\AbstractMVC\AbstractController;
use App\User\UserDatabase;

class LoginController extends AbstractController {

    public function __construct(LoginAuth $loginAuth, UserDatabase $userDatabase){
        $this->loginAuth = $loginAuth;
        $this->userDatabase = $userDatabase;
    }


    public function loadLoginPage(){
        $error = null;
        if (!empty($_POST)){

            $mail = htmlspecialchars($_POST["emailAddress"]);
            $password = htmlspecialchars($_POST["password"]);
            $user = $this->userDatabase->getUserByEmail($mail);
            if($user->active > 0){
                if(!empty($_POST["stayin"])){
                    $this->loginAuth->buildStayin($mail);
                }
                $login = $this->loginAuth->checklogin($mail, $password);
                if ($login){
                    header("Location: /home");
                } else {
                    $error = "Die Email-Adresse oder das Passwort war leider falsch";
                }
            }
        }
        if(!isset($_SESSION["login"])){
            $this->loginAuth->checkStayin();
        }
        if(!empty($_SESSION["login"])){
            header("Location: /home");
        } else {
            $this->pageload("Login", "login", [
                'error' => $error
            ]);
        }
    }

    public function activateUser(){
        if($_SERVER["REQUEST_METHOD"] === "GET"){
            if(isset($_GET)){
                $mail = filter_var($_GET["email"], FILTER_SANITIZE_EMAIL);
                $activationCode = $_GET["activationCode"];
                $user = $this->userDatabase->getUnverifiedUser($mail);
                if($user){
                    $this->userDatabase->activateUserById($user->userid);
                    $_SESSION["verified"] = "activate";
                    header("Location: /login");
                } else {
                    $this->userDatabase->deleteUserById($user->userid);
                    header("Location: /register");
                }
            }
        }
    }
}