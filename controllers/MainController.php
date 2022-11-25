<?php
require_once "BaseGamesTwigController.php";

class MainController extends BaseGamesTwigController
{
    public $template = "main.twig";
    public $title = "Главная";

    public function getContext(): array
    {
        $context = parent::getContext();

        if (isset($_GET['type'])) {
            $query = $this->pdo->prepare("SELECT * FROM games WHERE type = :type AND status = 'accepted'");
            $query->bindValue("type", $_GET['type']);
            $query->execute();
        } else {
            $query = $this->pdo->query("SELECT * FROM games WHERE status = 'accepted'");
        }
        $context['games'] = $query->fetchAll();

        $query = $this->pdo->query("SELECT * FROM types");
        $context['types'] = $query->fetchAll();

        $context['is_admin'] = $_SESSION['is_logged_admin'];
        $context['is_owner'] = $_SESSION['is_logged_owner'];

        return $context;
    }
}
