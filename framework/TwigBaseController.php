<?php
require_once "BaseController.php";

class TwigBaseController extends BaseController
{
    public $title = "";
    public $template = "";
    public $urlTitle = "";
    public $image = "";
    public $info = "";
    protected \Twig\Environment $twig;

    public function setTwig($twig)
    {
        $this->twig = $twig;
    }

    public function getContext(): array
    {
        $context = parent::getContext();
        $query = $this->pdo->query("SELECT type, typeRu, ruName, id FROM games");
        $context['title'] = $this->title;
        $context['template'] = $this->template;
        $context['urlTitle'] = $this->urlTitle;
        $context['image'] = $this->image;
        $context['info'] = $this->info;

        $data = $query->fetchAll();
        $context['game'] = $data;
        $context['games'] = $data;
        $typesQuery = $this->pdo->query("SELECT * FROM types");
        $context['types'] = $typesQuery->fetchAll();

        return $context;
    }

    public function get(array $context)
    {
        echo $this->twig->render($this->template, $context);
    }
}
