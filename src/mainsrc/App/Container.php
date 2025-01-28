<?php

namespace App\App;

use App\Connections\ConMySQL;
use App\Home\MVC\HomeController;
use App\Logger\LoggerDatabase;
use App\Logger\MVC\LoggerController;
use App\Login\MVC\LoginAuth;
use App\Login\MVC\LoginController;
use App\Logout\MVC\LogoutController;
use App\Offers\MVC\OffersController;
use App\Offers\OffersDatabase;
use App\PasswordReset\MVC\PasswordResetController;
use App\PasswordReset\PasswordResetDatabase;
use App\Profil\MVC\ProfilController;
use App\Register\MVC\RegisterController;
use App\SecurityLogin\SecurityLoginDatabase;
use App\Server\MVC\ServerController;
use App\Server\ServerDatabase;
use App\User\MVC\UserController;
use App\User\UserDatabase;


class Container {

    private $classInstances = [];
    private $builds = [];

    public function __construct(){
        $this->builds = [
            'loggerDatabase' => function(){
            return new LoggerDatabase($this->build('pdo'));
            },
            'loggerController' => function(){
            return new LoggerController($this->build('loggerDatabase'));
            },
            'profilController' => function(){
                return new ProfilController($this->build('userDatabase'), $this->build('loggerDatabase'));
            },
            'passwordResetDatabase' => function(){
                return new PasswordResetDatabase($this->build('pdo'));
            },
            'passwordResetController' => function(){
                return new PasswordResetController($this->build('passwordResetDatabase'), $this->build('userDatabase'));
            },
            'offersController' => function(){
                return new OffersController($this->build('offersDatabase'), $this->build('userDatabase'), $this->build('loggerDatabase'));
            },
            'offersDatabase' => function(){
                return new OffersDatabase($this->build('pdo'));
            },
            'securityLoginDatabase' => function(){
                return new SecurityLoginDatabase($this->build('pdo'));
            },
            'homeController' => function(){
                return new HomeController($this->build('userDatabase'), $this->build('offersDatabase'), $this->build('loggerDatabase'));
            },
            'userController' => function(){
                return new UserController($this->build('userDatabase'));
            },
            'userDatabase' => function(){
                return new UserDatabase($this->build('pdo'));
            },
            'logoutController' => function(){
                return new LogoutController($this->build('securityLoginDatabase'));
            },
            'serverController' => function(){
                return new ServerController($this->build('serverDatabase'));
            },
            'registerController' => function(){
                return new RegisterController($this->build("userDatabase"));
            },
            'loginController' => function(){
                return new LoginController($this->build("loginAuth"), $this->build("userDatabase"));
            },
            'loginAuth' => function(){
                return new LoginAuth($this->build("userDatabase"), $this->build("securityLoginDatabase"));
            },
            'router' => function(){
            return new Router($this->build("container"));
            },
            "container" => function(){
            return new Container();
            },
            'pdo' => function(){
            $connection = new ConMySQL();
            return $connection->conToMySQL1();
            }
        ];
    }


    public function build($objekt){
        if (isset($this->builds[$objekt])){
            if (!empty($this->classInstances[$objekt])){
                return $this->classInstances[$objekt];
            }
            $this->classInstances[$objekt] = $this->builds[$objekt]();
        }
        return $this->classInstances[$objekt];
    }
}