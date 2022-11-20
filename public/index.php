<?php
require_once '../vendor/autoload.php';
require_once '../framework/autoload.php';
require_once '../controllers/AuthController.php';
require_once '../controllers/MainController.php';
require_once "../controllers/Controller404.php";
require_once "../controllers/ObjectController.php";
require_once "../controllers/SearchController.php";
require_once "../controllers/GamesCreateController.php";
require_once "../controllers/GamesEditController.php";
require_once "../controllers/GamesDeleteController.php";
require_once "../controllers/TypeCreateController.php";
require_once "../middleware/LoginRequiredMiddleware.php";
require_once "../middleware/LoginRequiredAdminMiddleware.php";


$loader = new \Twig\Loader\FilesystemLoader('../views');
$twig = new \Twig\Environment($loader, [
    "debug" => true
]);

$twig->addExtension(new \Twig\Extension\DebugExtension());

$pdo = new PDO("mysql:host=localhost;dbname=card_games;charset=utf8", "root", "");
$router = new Router($twig, $pdo);
$router->add("/login", AuthController::class);
$router->add("/", MainController::class)
    ->middleware(new LoginRequiredMiddleware());
$router->add("/games/(?P<id>\d+)", ObjectController::class)
    ->middleware(new LoginRequiredMiddleware());
$router->add("/search", SearchController::class)
    ->middleware(new LoginRequiredMiddleware());
$router->add("/games/create", GamesCreateController::class)
    ->middleware(new LoginRequiredAdminMiddleware());
$router->add("/games/(?P<id>\d+)/edit", GamesEditController::class)
    ->middleware(new LoginRequiredAdminMiddleware());
$router->add("/games/(?P<id>\d+)/delete", GamesDeleteController::class)
    ->middleware(new LoginRequiredAdminMiddleware());
$router->add("/types/create", TypeCreateController::class)
    ->middleware(new LoginRequiredAdminMiddleware());


$router->get_or_default(Controller404::class);
