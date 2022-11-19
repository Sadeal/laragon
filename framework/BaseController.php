<?php
// класс абстрактный, чтобы нельзя было создать экземпляр
abstract class BaseController
{

    public PDO $pdo; // добавил поле
    public array $params;

    public function setPDO(PDO $pdo)
    { // и сеттер для него
        $this->pdo = $pdo;
    }

    public function setParams(array $params)
    {
        $this->params = $params;
    }

    // так как все вертится вокруг данных, то заведем функцию,
    // которая будет возвращать контекст с данными
    public function getContext(): array
    {
        return []; // по умолчанию пустой контекст
    }

    public function process_response()
    {
        $method = $_SERVER['REQUEST_METHOD']; // вытаскиваем метод
        $context = $this->getContext(); // вызываю context тут
        if ($method == 'GET') {
            $this->get($context); // а тут просто его пробрасываю внутрь
        } else if ($method == 'POST') {
            $this->post($context); // и здесь
        }
    }
    // с помощью функции get будет вызывать непосредственно рендеринг
    // так как рендерить необязательно twig шаблоны, а можно, например, всякий json
    // то метод сделаем абстрактным, ну типа кто наследуем BaseController
    // тот обязан переопределить этот метод
    public function get(array $context)
    {
    } // ну и сюда добавил в качестве параметра
    public function post(array $context)
    {
    } // и сюда
}
