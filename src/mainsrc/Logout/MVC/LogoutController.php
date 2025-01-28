<?php

namespace App\Logout\MVC;

use App\App\AbstractMVC\AbstractController;
use App\SecurityLogin\SecurityLoginDatabase;

class LogoutController extends AbstractController {

    public function __construct(SecurityLoginDatabase $securityLoginDatabase){
        $this->securityLoginDatabase = $securityLoginDatabase;
    }

    public function loadLogoutPage(){
        unset($_SESSION["login"]);
        $this->securityLoginDatabase->deleteStayindata($_SESSION["userid"]);
        setcookie("identifier", "", time() - 3600);
        setcookie("securitytoken", "", time() - 3600);
        $this->pageload("Logout", "logout", []);
    }
}