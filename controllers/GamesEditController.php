<?php
require_once "BaseGamesTwigController.php";

class GamesEditController extends BaseController
{
	public $template = "games_edit.twig";


	public function getContext(): array
	{
		$context = parent::getContext();

		$id = $this->params['id'];

		$sql = <<<EOL
SELECT * FROM games WHERE id = :id
EOL;
		$query = $this->pdo->prepare($sql);
		$query->bindValue("id", $id);
		$query->execute();

		$data = $query->fetchAll();

		$context['object'] = $data;

		return $context;
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
UPDATE games
SET title = :title, ruName = :ruName, image = :image_url, type = :type, typeRu = :typeRu, info = :info
EOL;

		$query = $this->pdo->prepare($sql);
		// привязываем параметры
		$query->bindValue("title", $title);
		$query->bindValue("ruName", $ruName);
		$query->bindValue("type", $type);
		$query->bindValue("image_url", $image_url);
		$query->bindValue("typeRu", $typeRu);
		$query->bindValue("info", $info);

		$query->execute();

		$context['message'] = 'Вы успешно обновили игру';
		$context['id'] = $this->pdo->lastInsertId(); // получаем id нового добавленного объекта

		$this->get($context);
	}
}
