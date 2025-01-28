<?php

namespace App\Login\MVC;

use App\SecurityLogin\SecurityLoginDatabase;
use App\User\UserDatabase;

class LoginAuth {

    public function __construct(UserDatabase $userDatabase, SecurityLoginDatabase $securityLoginDatabase){
        $this->userDatabase = $userDatabase;
        $this->securityLoginDatabase = $securityLoginDatabase;
    }

    private function setIdentifier(): string{
        return bin2hex(time() . random_bytes(8));
    }

    private function setSecurityToken(): string{
        return bin2hex(time() . random_bytes(10));
    }


    public function buildStayin($mail){
        $identifier = $this->setIdentifier();
        $securitytoken = $this->setSecurityToken();
        $user = $this->userDatabase->getUser("", $mail);
        $this->securityLoginDatabase->newStayin($user->userid, $identifier, password_hash($securitytoken, PASSWORD_DEFAULT));
        setcookie("identifier", $identifier, time() + (3600*2));
        setcookie("securitytoken", $securitytoken, time() + (3600*2));
    }

    public function checklogin($mail, $password): bool
    {
        $user = $this->userDatabase->getUser("", $mail);
        if ($user){
            if (password_verify($password, $user->password)){
                $user = $this->userDatabase->getUser("", $mail);
                session_regenerate_id(true);
                $_SESSION["userid"] = $user->userid;
                $_SESSION["userPermission"] = "simple";
                $_SESSION["username"] = $user->username;
                $_SESSION["stufe"] = $user->stufe;
                $_SESSION["geschlecht"] = $user->geschlecht;
                $_SESSION["lieblingsfach"] = $user->lieblingsfach;
                $_SESSION["gebucht"] = $user->gebucht;
                $_SESSION["erstellt"] = $user->erstellt;
                $_SESSION["login"] = true;
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    public function checkStayin(){
        if(isset($_COOKIE["identifier"])){
            if (isset($_COOKIE["securitytoken"])){
                $stayindata = $this->securityLoginDatabase->getStayinData($_COOKIE["identifier"]);
                if (!password_verify($_COOKIE["securitytoken"], $stayindata->securitytoken)){

                } else {
                    session_regenerate_id(true);
                    $newSecurityToken = $this->setSecurityToken();
                    $_SESSION["userid"] = $stayindata->userid;
                    $this->securityLoginDatabase->updateSecurityToken($stayindata->userid, password_hash($newSecurityToken, PASSWORD_DEFAULT));
                    setcookie("securitytoken", $newSecurityToken, time() + (3600*24*365));
                    $userdata = $this->userDatabase->getUser($stayindata->userid, "");
                    $_SESSION["userPermission"] = "simple";
                    $_SESSION["username"] = $userdata->username;
                    $_SESSION["stufe"] = $userdata->stufe;
                    $_SESSION["geschlecht"] = $userdata->geschlecht;
                    $_SESSION["lieblingsfach"] = $userdata->lieblingsfach;
                    $_SESSION["gebucht"] = $userdata->gebucht;
                    $_SESSION["erstellt"] = $userdata->erstellt;
                    $_SESSION["login"] = true;
                }
            }
        }
    }
}