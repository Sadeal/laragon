<?php
require_once "BaseGamesTwigController.php";

class GameSuggestDecisionController extends BaseGamesTwigController
{
	public $template = "suggestionDecision.twig";
	public $title = "Предложения";

	public function getContext(): array
	{
		$context = parent::getContext();

		$query = $this->pdo->query("SELECT * FROM suggestion");
		$context['suggestions'] = $query->fetchAll();

		return $context;
	}

	public function post(array $context)
	{
		$id = $_POST['id'];
		$sql = <<<EOL
SELECT *
FROM suggestion
WHERE id = :id
EOL;

		$query = $this->pdo->prepare($sql);
		$query->bindValue("id", $id);
		$query->execute();

		$data = $query->fetch();

		$title = $data['title'];
		$image = $data['image'];
		$ruName = $data['ruName'];
		$type = $data['type'];
		$typeRu = $data['typeRu'];
		$info = $data['info'];

		$sql = <<<EOL
INSERT INTO games (title, ruName, image, type, typeRu, info)
VALUES (:title, :ruName, :image, :type, :typeRu, :info)
EOL;

		$query = $this->pdo->prepare($sql);
		$query->bindValue("title", $title);
		$query->bindValue("ruName", $ruName);
		$query->bindValue("type", $type);
		$query->bindValue("image", $image);
		$query->bindValue("typeRu", $typeRu);
		$query->bindValue("info", $info);
		$query->execute();

		$sql = <<<EOL
DELETE FROM suggestion
WHERE id = :id
EOL;
		$query = $this->pdo->prepare($sql);
		$query->bindValue("id", $id);
		$query->execute();

		header("Location: /games/suggestion/decision");
		exit;

		$this->get($context);
	}
}
