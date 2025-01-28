<?php

namespace App\Offers\MVC;

use App\App\AbstractMVC\AbstractModel;

class OffersModel extends AbstractModel {
    public $id;
    public $lehrer;
    public $lehrerid;
    public $fach;
    public $status;
    public $jahrgang;
    public $email;
    public $beschreibung;
    public $gebuchteUser;
    public $angefragteUser;
}