<?php
require_once "BaseGamesTwigController.php";

class GamesCreateController extends BaseGamesTwigController
{
	public $template = "games_create.twig";


	public function getContext(): array
	{
		$context = parent::getContext();
		$query = $this->pdo->query("SELECT * FROM types");
		$context['allTypes'] = $query->fetchAll();
		$context['title'] = "Добавить игру";

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

		$sql = <<<EOL
INSERT INTO games (title, ruName, image, type, typeRu, info, status, suggest)
VALUES (:title, :ruName, :image_url, :type, :typeRu, :info, 'accepted', 'ADDED BY ADMIN')
EOL;

		$query = $this->pdo->prepare($sql);
		$query->bindValue("title", $title);
		$query->bindValue("ruName", $ruName);
		$query->bindValue("type", $type);
		$query->bindValue("image_url", $image_url);
		$query->bindValue("typeRu", $typeRu);
		$query->bindValue("info", $info);

		$query->execute();

		$context['message'] = 'Вы успешно добавили игру';
		$context['id'] = $this->pdo->lastInsertId();

		$this->get($context);
	}
}
