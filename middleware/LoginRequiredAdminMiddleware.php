<?php

class LoginRequiredAdminMiddleware extends BaseMiddleware
{
	public function apply(BaseController $controller, array $context)
	{
		if ($_SESSION['is_logged'] && $_SESSION['is_logged_admin'])
			return;
		else
			header('Location: /');
		exit;

		/*
		$sql = <<<EOL
SELECT login, pass FROM users
WHERE type = 'admin'
EOL;
		$query = $controller->pdo->query($sql);
		$context['user'] = $query->fetchAll();

		$user = isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : '';
		$password = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : '';

		for ($i = 0; $i < count($context['user']); $i++) {
			if ($user == $context['user'][$i]['login'] && $password == $context['user'][$i]['pass']) {
				return;
			}
		}
		echo "<script type='text/javascript'>alert('Вы не вошли как администратор');</script>";
		header('WWW-Authenticate: Basic realm=""');
		exit;
		*/
	}
}
