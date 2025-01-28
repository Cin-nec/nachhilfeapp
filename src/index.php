<?php
session_start();
require_once "init.php";

$router = $Container->build("router");

if (isset($_SERVER["PATH_INFO"])){
    $request = $_SERVER["PATH_INFO"];
}else {
    $request = $_SERVER["REQUEST_URI"];
}

if ($request == "/home"){
    $router->add("homeController", "loadHomePage");
}
#Logger - Alle Notifications
elseif ($request == "/logger"){
    $router->add("loggerController", "loadLoggerPage");
}
#Angebote - gebucht
elseif ($request == "/angeboteGebucht" ){
    $router->add("offersController", "loadBookedOffersPage");
}
#Angebote - gebucht - Details
elseif ($request == "/angeboteGebuchtDetails"){
    $router->add("offersController", "loadDetailBookedOffersPage");
}
#Angebote - selber erstellt
elseif ($request == "/angeboteLehrer" ){
    $router->add("offersController", "loadOwnOffersPage");
}
#Angebote - selber erstellt - Details
elseif ($request == "/angeboteLehrerDetails"){
    $router->add("offersController", "loadDetailOwnOffersPage");
}
#Angebote - noch frei und buchbar
elseif ($request == "/angeboteOffen"){
    $router->add("offersController", "loadOpenOffersPage");
}
#Angebote - noch frei und buchbar - Details
elseif ($request == "/angeboteOffenDetails"){
    $router->add("offersController", "loadDetailOpenOffersPage");
}
#Angebote - angefragt
elseif ($request == "/angeboteAngefragt"){
    $router->add("offersController", "loadRequestOffersPage");
}
#Angebote - angefragt - Details
elseif ($request == "/angeboteAngefragtDetails"){
    $router->add("offersController", "loadDetailRequestOffersPage");
}
#Login & Register & Logout & Activation & Passwort zurücksetzen
elseif ($request == "/login"){
    $router->add("loginController", "loadLoginPage");
}
elseif ($request == "/logout"){
    $router->add("logoutController", "loadLogoutPage");
}
elseif ($request == "/register"){
    $router->add("registerController", "register");
}
elseif ($request == "/active"){
    $router->add("loginController", "activateUser");
}
elseif ($request == "/passwordResetEmail"){
    $router->add("passwordResetController", "loadPasswordEnterMailPage");
}
elseif ($request == "/passwordResetChangePassword"){
    $router->add("passwordResetController", "loadChangePasswordPage");
}
#Profil
elseif ($request == "/profil"){
    $router->add("profilController", "loadProfilPage");
}
else {
    $router->add("homeController", "loadHomePage");
}

?>

