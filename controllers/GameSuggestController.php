<?php
require_once "BaseGamesTwigController.php";

class GameSuggestController extends BaseGamesTwigController
{
	public $template = "suggestion.twig";


	public function getContext(): array
	{
		$context = parent::getContext();
		$query = $this->pdo->query("SELECT * FROM types");
		$context['allTypes'] = $query->fetchAll();
		$context['title'] = "Предложить игру";

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
INSERT INTO suggestion (title, ruName, image, type, typeRu, info)
VALUES (:title, :ruName, :image_url, :type, :typeRu, :info)
EOL;

		$query = $this->pdo->prepare($sql);
		$query->bindValue("title", $title);
		$query->bindValue("ruName", $ruName);
		$query->bindValue("type", $type);
		$query->bindValue("image_url", $image_url);
		$query->bindValue("typeRu", $typeRu);
		$query->bindValue("info", $info);

		$query->execute();

		$context['message'] = 'Вы успешно предложили игру';
		$context['id'] = $this->pdo->lastInsertId();

		$this->get($context);
	}
}
