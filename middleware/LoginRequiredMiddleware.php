<?php

class LoginRequiredMiddleware extends BaseMiddleware
{
	public function apply(BaseController $controller, array $context)
	{
		if ($_SESSION['is_logged']) {
			return;
		} else {
			header('Location: /login');
			exit;
		}
		/*
		$sql = <<<EOL
SELECT login, pass FROM users
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
		header('WWW-Authenticate: Basic realm="Games"');
		http_response_code(401);
		exit;
		*/
	}
}
