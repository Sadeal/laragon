<?php
require_once "BaseGamesTwigController.php";

class AuthController extends BaseGamesTwigController
{
	public $template = "auth.twig";


	public function getContext(): array
	{
		$context = parent::getContext();
		$_SESSION['is_logged'] = false;
		$_SESSION['is_logged_admin'] = false;
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

		$data = $query->fetch();
		if ($login == '') {
			$context['message'] = 'Введите логин!';
		} else {
			if ($pass == '') {
				$context['message'] = 'Введите пароль!';
			} else {
				if ($data) {
					if ($data['type'] == "user") {
						$_SESSION['is_logged'] = true;
						$_SESSION['is_logged_admin'] = false;
						$_SESSION['is_logged_owner'] = false;
					} else {
						if ($data['type'] == "admin") {
							$_SESSION['is_logged'] = true;
							$_SESSION['is_logged_admin'] = true;
							$_SESSION['is_logged_owner'] = false;
						} else {
							$_SESSION['is_logged'] = true;
							$_SESSION['is_logged_admin'] = true;
							$_SESSION['is_logged_owner'] = true;
						}
					}
					$context['message'] = null;
					header("Location: /");
				} else {
					$context['message'] = 'Неверный логин и/или пароль';
				}
			}
		}
		$context['logData'] = $login;
		$this->get($context);
	}
}
