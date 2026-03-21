<?php
//============== Mapping des vues et contrôleurs
$routes = [
    "signin" => [
        "view" => null,
        "controller" => "controller/connexionController.php",
    ],
    "logout" => [
        "view" => null,
        "controller" => "controller/deconnexionController.php",
    ],
    "dashboard" => [
        "view" => "views/dashboard.php",
        "controller" => null,
    ],
    "user" => [
        "view" => "views/user/index.php",
        "controller" => null,
    ],
    "user.edit" => [
        "view" => "views/user/edit.php",
        "controller" => null,
    ],
    "user.control" => [
        "view" => null,
        "controller" => "controller/userController.php",
    ],
    "specialite" => [
        "view" => "views/specialite/index.php",
        "controller" => null,
    ],
    "specialite.edit" => [
        "view" => "views/specialite/edit.php",
        "controller" => null,
    ],
    "specialite.control" => [
        "view" => null,
        "controller" => "controller/specialiteController.php",
    ],
    "mode" => [
        "view" => "views/mode/index.php",
        "controller" => null,
    ],
    "mode.edit" => [
        "view" => "views/mode/edit.php",
        "controller" => null,
    ],
    "mode.control" => [
        "view" => null,
        "controller" => "controller/modeController.php",
    ],
    "consultation" => [
        "view" => "views/consultation/index.php",
        "controller" => null,
    ],
    "consultation.edit" => [
        "view" => "views/consultation/edit.php",
        "controller" => null,
    ],
    "consultation.control" => [
        "view" => null,
        "controller" => "controller/consultationController.php",
    ],
];


// Fonction pour récupérer la route
function getRoute($routes) {
    $routeKey = $_GET['view'] ?? null;
    if ($routeKey && array_key_exists($routeKey, $routes)) {
        return $routes[$routeKey];
    }
    // return [
    //     "view" => "views/404.php",
    //     "controller" => null,
    // ];
    header('Location:../index.php');
    return null;
}

// Récupérer la route demandée
$route = getRoute($routes);

?>