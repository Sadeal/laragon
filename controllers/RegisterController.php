<?php
require_once "BaseGamesTwigController.php";

class RegisterController extends BaseGamesTwigController
{
	public $template = "register.twig";


	public function getContext(): array
	{
		$context = parent::getContext();

		return $context;
	}

	public function post(array $context)
	{
		$login = $_POST['login'];
		$pass = $_POST['pass'];
		$invite = $_POST['invite'];

		$sql = <<<EOL
SELECT login
FROM users
WHERE login = :login
EOL;
		$query = $this->pdo->prepare($sql);
		$query->bindValue("login", $login);
		$query->execute();

		$data = $query->fetch();
		if (!$data) {
			if ($login == '') {
				$context['message'] = 'Введите логин!';
			} else {
				if ($pass == '') {
					$context['message'] = 'Введите пароль!';
				} else {
					if ($invite == '21232f297a57a5a743894a0e4a801fc3') {
						$sql = <<<EOL
	INSERT INTO users (login, pass, type)
	VALUES (:login, :pass, :type)
	EOL;
						$query = $this->pdo->prepare($sql);
						$query->bindValue("login", $login);
						$query->bindValue("pass", $pass);
						$query->bindValue("type", 'admin');
						$query->execute();
					} else {
						$sql = <<<EOL
	INSERT INTO users (login, pass, type)
	VALUES (:login, :pass, :type)
	EOL;
						$query = $this->pdo->prepare($sql);
						$query->bindValue("login", $login);
						$query->bindValue("pass", $pass);
						$query->bindValue("type", 'user');
						$query->execute();
					}
					$context['message'] = null;
					header("Location: /login");
				}
			}
		} else {
			$context['message'] = 'Данный пользователь уже существует!';
		}
		$this->get($context);
	}
}
