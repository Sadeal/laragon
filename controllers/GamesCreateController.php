<?php
require_once "BaseGamesTwigController.php";

class GamesCreateController extends BaseGamesTwigController
{
	public $template = "games_create.twig";

	public function get(array $context) // добавили параметр
	{
		parent::get($context); // пробросили параметр
	}

	public function post(array $context)
	{
		$title = $_POST['title'];
		$ruName = $_POST['ruName'];
		$type = $_POST['type'];
		$typeRu = $_POST['typeRu'];
		$info = $_POST['info'];

		$tmp_name = $_FILES['image']['tmp_name'];
		$name =  $_FILES['image']['name'];
		move_uploaded_file($tmp_name, "../public/images/$name");
		$image_url = "/images/$name";

		// создаем текст запрос
		$sql = <<<EOL
INSERT INTO games (title, ruName, image, type, typeRu, info)
VALUES (:title, :ruName, :image_url, :type, :typeRu, :info)
EOL;

		// подготавливаем запрос к БД
		$query1 = $this->pdo->query("SELECT * FROM types");
		$context['allTypes'] = $query1->fetchAll();
		print_r($context);

		$query = $this->pdo->prepare($sql);
		// привязываем параметры
		$query->bindValue("title", $title);
		$query->bindValue("ruName", $ruName);
		$query->bindValue("type", $type);
		$query->bindValue("image_url", $image_url);
		$query->bindValue("typeRu", $typeRu);
		$query->bindValue("info", $info);

		$query->execute();

		$context['message'] = 'Вы успешно создали объект';
		$context['id'] = $this->pdo->lastInsertId(); // получаем id нового добавленного объекта

		$this->get($context);
	}
}
