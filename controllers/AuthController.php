<?php
require_once "BaseGamesTwigController.php";

class AuthController extends BaseGamesTwigController
{
	public $template = "auth.twig";


	public function getContext(): array
	{
		$context = parent::getContext();

		return $context;
	}

	public function post(array $context)
	{
		$login = $_POST['login'];
		$pass = $_POST['pass'];

		$sql = <<<EOL
SELECT type
FROM users
WHERE login = :login AND pass = :pass
EOL;
		$query = $this->pdo->prepare($sql);
		$query->bindValue("login", $login);
		$query->bindValue("pass", $pass);
		$query->execute();

		$data = $query->fetchAll();
		if (!is_null($data[0])) {
			if ($data[0]['type'] == "user") {
				$_SESSION['is_logged'] = true;
				$_SESSION['is_logged_admin'] = false;
			} else {
				$_SESSION['is_logged'] = true;
				$_SESSION['is_logged_admin'] = true;
			}
			header("Location: /");
			exit;
		} else {
			$context['message'] = 'Неверный логин и/или пароль';
		}
		$this->get($context);
	}
}
