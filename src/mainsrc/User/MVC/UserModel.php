<?php

namespace App\User\MVC;

use App\App\AbstractMVC\AbstractModel;

class UserModel extends AbstractModel {
    # fetcht die Daten aus der User Database um sie unter diesen Variablen aufrufbar zu machen
    public $userid;
    public $username;
    public $stufe;
    public $geschlecht;
    public $lieblingsfach;
    public $gebucht;
    public $erstellt;
    public $mail;
    public $password;
    public int $active;
    public $activation_code;
    public $activated_at;
    public $activation_expiry;
}