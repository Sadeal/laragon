<?php
require_once "BaseGamesTwigController.php";

class TypeCreateController extends BaseGamesTwigController
{
	public $template = "type_create.twig";

	public function get(array $context)
	{
		$context['title'] = "Добавить тип";
		parent::get($context);
	}

	public function post(array $context)
	{
		$type = $_POST['type'];
		$typeRu = $_POST['typeRu'];

		$sql = <<<EOL
INSERT INTO types (type, typeRu)
VALUES (:type, :typeRu)
EOL;

		$query = $this->pdo->prepare($sql);
		$query->bindValue("type", $type);
		$query->bindValue("typeRu", $typeRu);

		$query->execute();

		$context['message'] = 'Вы успешно добавили тип';

		$this->get($context);
	}
}
