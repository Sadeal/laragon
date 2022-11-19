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
            $query = $this->pdo->prepare("SELECT * FROM games WHERE type = :type");
            $query->bindValue("type", $_GET['type']);
            $query->execute();
        } else {
            $query = $this->pdo->query("SELECT * FROM games");
        }

        // стягиваем данные через fetchAll() и сохраняем результат в контекст
        $context['games'] = $query->fetchAll();

        return $context;
    }
}
