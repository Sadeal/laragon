<?php
require_once "BaseController.php"; // обязательно импортим BaseController

class TwigBaseController extends BaseController
{
    public $title = ""; // название страницы
    public $template = ""; // шаблон страницы
    public $urlTitle = "";
    public $image = "";
    public $info = "";
    protected \Twig\Environment $twig; // ссылка на экземпляр twig, для рендернига

    public function setTwig($twig)
    {
        $this->twig = $twig;
    }

    // переопределяем функцию контекста
    public function getContext(): array
    {
        $context = parent::getContext(); // вызываем родительский метод
        $query = $this->pdo->query("SELECT type, typeRu, ruName, id FROM games");
        $context['title'] = $this->title; // добавляем title в контекст
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

    // функция гет, рендерит результат используя $template в качестве шаблона
    // и вызывает функцию getContext для формирования словаря контекста
    public function get(array $context)
    { // добавил аргумент в get
        echo $this->twig->render($this->template, $context); // а тут поменяем getContext на просто $context
    }
}
