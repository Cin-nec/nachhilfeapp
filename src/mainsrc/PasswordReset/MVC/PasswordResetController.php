<?php

namespace App\PasswordReset\MVC;

use App\App\AbstractMVC\AbstractController;
use App\PasswordReset\PasswordResetDatabase;
use App\User\UserDatabase;
use DateTime;

class PasswordResetController extends AbstractController {

    public function __construct(PasswordResetDatabase $passwordResetDatabase, UserDatabase $userDatabase){
        $this->passwordResetDatabase = $passwordResetDatabase;
        $this->userDatabase = $userDatabase;
        $this->appURL = 'https://cinnec.de';
        $this->serverEmailAddress = 'register@cinnec.de';
    }

    public function loadPasswordEnterMailPage(){
        $error = null;
        $success = null;
        if(!empty($_POST)){
            $mail = htmlspecialchars($_POST["mail"]);
            if($this->userDatabase->getUserByEmail($mail)){
                if($this->passwordResetDatabase->getResetCodeEntryByEmail($mail)){
                    $this->passwordResetDatabase->deleteResetCodeEntryByEmail($mail);
                }
                $resetCode = password_hash($this->generateResetCode(), PASSWORD_DEFAULT);
                $codeExpiry = date('Y-m-d H:i:s', time() + 70 * 60);
                $this->passwordResetDatabase->newResetCodeEntry($mail, $resetCode, $codeExpiry);
                $this->sendResetEmail($mail, $resetCode);
                $success = "Es wurde eine Bestätigunsemail an diese Adresse gesendet.";
            } else {
                $error = "Diese E-Mail Adresse existiert nicht in unserem System.";
            }
        }
        $this->pageload("PasswordReset", "entermail", [
            "error" => $error,
            "success" => $success,
        ]);
    }

    public function loadChangePasswordPage(){
        $error = null;
        if(!empty($_GET)){
            $mail = $_GET["email"];
            $resetCode = $_GET["resetCode"];
            if(!empty($_POST)){
                if(isset($_POST["password"]) && is_string($_POST["password"]) && !empty($_POST["password"])) {
                    $password = htmlspecialchars($_POST["password"]);
                    $password = trim($password);
                    $pattern = '/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/';
                    if(!preg_match($pattern, $password)){
                        $error = "Tut mir leid, ein starkes Passwort ist Pflicht.";
                    } else {
                        $entry = $this->passwordResetDatabase->getResetCodeEntryByEmailAndToken($mail, $resetCode);
                        if($entry){
                            $codeExpiry = DateTime::createFromFormat('Y-m-d H:i:s', $entry->code_expiry);
                            $actualTime = new DateTime();
                            $diff = $actualTime->diff($codeExpiry);
                            if($diff->i > 10 or $diff->h > 1 or $diff->days > 1){
                                $error = "Die Zeit für das Ändern des Passworts ist abgelaufen.";
                            } else {
                                $user = $this->userDatabase->getUserByEmail($mail);
                                $this->userDatabase->updateUserPasswordById($user->userid, password_hash($password, PASSWORD_DEFAULT));
                                header("Location: /login");
                            }
                        } else {
                            $error = "Die Email Adresse oder der Sicherheitscode stimmen nicht mit der Vorlage überein.";
                        }
                    }
                } else {
                    $error = "Tut mir leid, ein starkes Passwort ist Pflicht.";
                }
            }
        }
        $this->pageload("PasswordReset", "changepassword", [
            "error" => $error,
        ]);
    }

    private function generateResetCode() : string {
        return bin2hex(random_bytes(16));
    }

    private function sendResetEmail(string $mail, string $activationCode) : void {
        $resetLink = $this->appURL . "/passwordResetChangePassword?email=$mail&resetCode=$activationCode";

        $betreff = 'Passwort zurückzusetzen';
        $message = <<<MESSAGE
                 Hallo,
                 Bitte folge dem Link um dein Passwort zurück zusetzen:
                 $resetLink
                 Vielen Dank!
                MESSAGE;

        $header = "From: $this->serverEmailAddress";

        mail($mail, $betreff, nl2br($message), $header);
    }
}