<?php
//============== Mapping des vues
$views= array(
    "signin" => "controller/connexionController.php",
    "logout" => "controller/deconnexionController.php",
    "dashboard" => "views/dashboard.php",
    "user" => "views/user/index.php",
    "user.edit" => "views/user/edit.php",
    "user.control" => "controller/userController.php",
    "pharmacie" => "views/pharmacies.php",
    "medicament" => "views/medicaments.php",
    "settings" => "views/settings.php",
    "all_medicament" => "views/all_medicaments.php",
    "coupon" => "views/coupons.php"
);

$view= null;
if(isset($_GET['view']) == true) {
    if(array_key_exists($_GET['view'], $views) == true) {
        $view = $views[$_GET['view']];
    }
    else {
        $view = "views/404.php";
    }
}
else {
    //header("Location:../index.php");
    $view = "views/dashboard.php";
}





//===================== Mapping des controllers

$controllers= array(
    "signin" => "controller/connexionController.php",
    "logout" => "controller/deconnexionController.php",
    "user.control" => "controller/userController.php",
);

$control= null;
if(isset($_GET['control']) == true) {
    if(array_key_exists($_GET['control'], $controllers) == true) {
        $control = $controllers[$_GET['control']];
    }
    else {
        $control = "views/404.php";
    }
}
else {
    $control= null;
}

?>