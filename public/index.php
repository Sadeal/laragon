<?php
require_once '../vendor/autoload.php';
require_once '../framework/autoload.php';
require_once '../controllers/MainController.php';
require_once "../controllers/Controller404.php";
require_once "../controllers/ObjectController.php";
require_once "../controllers/SearchController.php";
require_once "../controllers/GamesCreateController.php";
require_once "../controllers/GamesEditController.php";
require_once "../controllers/GamesDeleteController.php";
require_once "../controllers/TypeCreateController.php";
require_once "../middleware/LoginRequiredMiddeware.php";


$loader = new \Twig\Loader\FilesystemLoader('../views');
$twig = new \Twig\Environment($loader, [
    "debug" => true
]);

$twig->addExtension(new \Twig\Extension\DebugExtension()); // и активируем расширение

$pdo = new PDO("mysql:host=localhost;dbname=card_games;charset=utf8", "root", "");

$router = new Router($twig, $pdo);
$router->add("/", MainController::class);
$router->add("/games/(?P<id>\d+)", ObjectController::class);
$router->add("/search", SearchController::class);

$router->add("/games/create", GamesCreateController::class)
    ->middleware(new LoginRequiredMiddeware());
$router->add("/games/(?P<id>\d+)/edit", GamesEditController::class)
    ->middleware(new LoginRequiredMiddeware());
$router->add("/games/(?P<id>\d+)/delete", GamesDeleteController::class)
    ->middleware(new LoginRequiredMiddeware());
$router->add("/types/create", TypeCreateController::class)
    ->middleware(new LoginRequiredMiddeware());


$router->get_or_default(Controller404::class);
