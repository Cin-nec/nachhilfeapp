<?php

namespace App\User\MVC;

use App\App\AbstractMVC\AbstractController;
use App\User\UserDatabase;

class UserController extends AbstractController {

    public function __construct(UserDatabase $userDatabase){
        $this->userDatabase = $userDatabase;
    }
    public function userCreate($action){
        if($action == "create"){
            $this->pageload("User", "user", [
                "action" => ["name" => "Baby", "test" => 25],
            ]);
        } else {
            $this->pageload("User", "user", [
                "action" => "gay",
            ]);
        }
    }



}