<?php
require_once "BaseGamesTwigController.php";

class TypeCreateController extends BaseGamesTwigController
{
	public $template = "type_create.twig";

	public function get(array $context) // добавили параметр
	{
		parent::get($context); // пробросили параметр
	}

	public function post(array $context)
	{
		$type = $_POST['type'];
		$typeRu = $_POST['typeRu'];

		// создаем текст запрос
		$sql = <<<EOL
INSERT INTO types (type, typeRu)
VALUES (:type, :typeRu)
EOL;

		// подготавливаем запрос к БД
		$query = $this->pdo->prepare($sql);
		// привязываем параметры
		$query->bindValue("type", $type);
		$query->bindValue("typeRu", $typeRu);

		$query->execute();

		$context['message'] = 'Вы успешно добавили тип';

		$this->get($context);
	}
}
