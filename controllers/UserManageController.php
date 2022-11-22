<?php
require_once "BaseGamesTwigController.php";

class UserManageController extends BaseGamesTwigController
{
	public $template = "userManage.twig";


	public function getContext(): array
	{
		$context = parent::getContext();

		$query = $this->pdo->prepare("SELECT id, login, type FROM users");
		$query->execute();
		$context['users'] = $query->fetchAll();

		return $context;
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

		$context['message'] = 'Вы успешно обновили данные о пользователе' . $login;

		header("Location: /users/manage");
		exit;

		$this->get($context);
	}
}
