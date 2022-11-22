<?php
require_once '../vendor/autoload.php';
require_once '../framework/autoload.php';
require_once '../controllers/AuthController.php';
require_once '../controllers/RegisterController.php';
require_once '../controllers/MainController.php';
require_once "../controllers/Controller404.php";
require_once "../controllers/ObjectController.php";
require_once "../controllers/SearchController.php";
require_once "../controllers/GameSuggestController.php";
require_once "../controllers/GameSuggestDecisionController.php";
require_once "../controllers/GamesCreateController.php";
require_once "../controllers/GamesEditController.php";
require_once "../controllers/GamesDeleteController.php";
require_once "../controllers/GamesDeleteSuggestionController.php";
require_once "../controllers/TypeCreateController.php";
require_once "../controllers/UserManageController.php";
require_once "../middleware/LoginRequiredMiddleware.php";
require_once "../middleware/LoginRequiredAdminMiddleware.php";
require_once "../middleware/LoginRequiredOwnerMiddleware.php";


$loader = new \Twig\Loader\FilesystemLoader('../views');
$twig = new \Twig\Environment($loader, [
    "debug" => true
]);
session_set_cookie_params(60 * 60 * 10);
session_start();
$_SESSION['is_logged'];
$_SESSION['is_logged_admin'];
$_SESSION['is_logged_owner'];

$twig->addExtension(new \Twig\Extension\DebugExtension());

$pdo = new PDO("mysql:host=localhost;dbname=card_games;charset=utf8", "root", "");
$router = new Router($twig, $pdo);
$router->add("/login", AuthController::class);
$router->add("/register", RegisterController::class);
$router->add("/", MainController::class)
    ->middleware(new LoginRequiredMiddleware());
$router->add("/games/(?P<id>\d+)", ObjectController::class)
    ->middleware(new LoginRequiredMiddleware());
$router->add("/search", SearchController::class)
    ->middleware(new LoginRequiredMiddleware());
$router->add("/games/suggestion", GameSuggestController::class)
    ->middleware(new LoginRequiredMiddleware());
$router->add("/games/create", GamesCreateController::class)
    ->middleware(new LoginRequiredAdminMiddleware());
$router->add("/games/(?P<id>\d+)/edit", GamesEditController::class)
    ->middleware(new LoginRequiredAdminMiddleware());
$router->add("/games/(?P<id>\d+)/delete", GamesDeleteController::class)
    ->middleware(new LoginRequiredAdminMiddleware());
$router->add("/games/suggestion/decision/(?P<id>\d+)/delete", GamesDeleteSuggestionController::class)
    ->middleware(new LoginRequiredAdminMiddleware());
$router->add("/types/create", TypeCreateController::class)
    ->middleware(new LoginRequiredAdminMiddleware());
$router->add("/games/suggestion/decision", GameSuggestDecisionController::class)
    ->middleware(new LoginRequiredAdminMiddleware());
$router->add("/users/manage", UserManageController::class)
    ->middleware(new LoginRequiredOwnerMiddleware());


$router->get_or_default(Controller404::class);
