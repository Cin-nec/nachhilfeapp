<?php

namespace App\Register\MVC;

use App\App\AbstractMVC\AbstractController;
use App\User\UserDatabase;

class RegisterController extends AbstractController {

    public function __construct(UserDatabase $userDatabase){
        $this->userDatabase = $userDatabase;
        $this->appURL = 'https://cinnec.de';
        $this->serverEmailAddress = 'register@cinnec.de';
    }

    public function register(){
        $fail = [
            "name" => "",
            "email" => "",
            "password" => "",
            "age" => "",
            "geschlecht" => "",
            "allgemein" => "",
        ];
        $passedValidation = true;
        if (!empty($_POST)){
            if(isset($_POST["submit"])){
                $username = "";
                $email = "";
                $password = "";
                $age = "";
                $geschlecht = "";
                if(isset($_POST["name"]) && is_string($_POST["name"]) && !empty($_POST["name"])) {
                    $username = htmlspecialchars($_POST["name"]);
                    $username = trim($username);
                    if(!ctype_alnum($username)){
                        $passedValidation = false;
                        $fail["name"] = "Bitte, keine Sonderzeichen!";
                    }
                } else {
                    $passedValidation = false;
                    $fail["name"] = "Ein Benutzername wäre doch nett";
                }

                if(isset($_POST["email"]) && is_string($_POST["email"]) && !empty($_POST["email"])) {
                    $email = htmlspecialchars($_POST["email"]);
                    $email = trim($email);
                    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $passedValidation = false;
                        $fail["email"] = "Keine gültige Email-Adresse o_o";
                    }
                    $user = $this->userDatabase->getUser("", $email);
                    if (!empty($user)){
                        $passedValidation = false;
                        $fail["email"] = "Du bist hier bereits registriert.";
                    }
                } else {
                    $passedValidation = false;
                    $fail["email"] = "Ohne Email-Adresse wird das nichts!";
                }

                if(isset($_POST["password"]) && is_string($_POST["password"]) && !empty($_POST["password"])) {
                    $password = htmlspecialchars($_POST["password"]);
                    $password = trim($password);
                    $pattern = '/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/';
                    if(!preg_match($pattern, $password)){
                        $passedValidation = false;
                        $fail["password"] = "Tut mir leid, ein starkes Passwort ist Pflicht.";
                    }
                } else {
                    $passedValidation = false;
                    $fail["password"] = "Tut mir leid, ein starkes Passwort ist Pflicht.";
                }

                if(isset($_POST["geschlecht"]) && is_string($_POST["geschlecht"]) && !empty($_POST["geschlecht"])) {
                    $geschlecht = htmlspecialchars($_POST["geschlecht"]);
                    $geschlecht = trim($geschlecht);
                } else {
                    $passedValidation = false;
                    $fail["geschlecht"] = "Gebe bitte nur zur Übersicht ein Geschlecht an.";
                }

                if(isset($_POST["age"]) && is_string($_POST["age"]) && !empty($_POST["age"])) {
                    $age = htmlspecialchars($_POST["age"]);
                    $age = trim($age);
                } else {
                    $passedValidation = false;
                    $fail["age"] = "Gib deine ungefährer Jahrgangsstufe an.";
                }

                if($passedValidation){
                    $activationExpiry = date('Y-m-d H:i:s', time() + 1 * 24 * 60 * 60);
                    $activationCode = password_hash($this->generateActivationCode(), PASSWORD_DEFAULT);
                    $this->sendActivationEmail($email, $activationCode);
                    $password_hash = password_hash($password, PASSWORD_DEFAULT);
                    $this->userDatabase->newUser($username,$age,$geschlecht,"mathe", $email,$password_hash, $activationCode, $activationExpiry);
                    $_SESSION["verified"] = "send";
                    header("Location: /login");
                } else {
                    $fail["allgemein"] = "Bitte überprüfe nochmals deine Eingaben!";
                }
            }
        }


        $this->pageload("Register", "register",[
            'fail' => $fail
        ]);
    }

    private function generateActivationCode() : string {
        return bin2hex(random_bytes(16));
    }

    private function sendActivationEmail(string $mail, string $activationCode) : void {
        $activationLink = $this->appURL . "/active?email=$mail&activationCode=$activationCode";

        $betreff = 'Bitte bestätige deine Email-Adresse';
        $message = <<<MESSAGE
                 Hallo,
                 Bitte folge dem Link um deine Email-Adresse zu bestätigen:
                 $activationLink
                 Vielen Dank!
                MESSAGE;

        $header = "From: $this->serverEmailAddress";

        mail($mail, $betreff, nl2br($message), $header);
    }
}