<?php
require_once "BaseGamesTwigController.php";

class UserManageController extends BaseGamesTwigController
{
	public $template = "userManage.twig";
	public $title = "Управление пользователями";


	public function getContext(): array
	{
		$context = parent::getContext();

		$query = $this->pdo->prepare("SELECT id, login, type FROM users");
		$query->execute();
		$context['users'] = $query->fetchAll();

		$id = isset($_GET['id']) ? $_GET['id'] : '';
		if ($id != '') {
			if ($id != '1') {
				$query = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
				$query->bindValue("id", $id);
				$query->execute();
				header("Location: /users/manage");
				exit;
			} else {
				$context['message'] = 'Нельзя удалить владельца';
			}
		}

		return $context;
	}

	public function get(array $context)
	{
		$context['title'] = "Добавить тип";
		parent::get($context);
	}

	public function post(array $context)
	{
		$login = $_POST['login'];
		$type = '';
		$sql = <<<EOL
SELECT type
FROM users
WHERE login = :login
EOL;
		$query = $this->pdo->prepare($sql);
		$query->bindValue("login", $login);
		$query->execute();
		$data = $query->fetch();
		if ($data['type'] == 'admin') {
			$type = 'user';
		} else {
			if ($data['type'] == 'user') {
				$type = 'admin';
			} else {
				$type = 'owner';
			}
		}

		$sql = <<<EOL
UPDATE users
SET type = :type
WHERE login = :login
EOL;
		$query = $this->pdo->prepare($sql);
		$query->bindValue("login", $login);
		$query->bindValue("type", $type);
		$query->execute();

		header("Location: /users/manage");
		exit;

		$this->get($context);
	}
}
