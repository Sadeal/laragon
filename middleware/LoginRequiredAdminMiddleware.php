<?php

class LoginRequiredAdminMiddleware extends BaseMiddleware
{
	public function apply(BaseController $controller, array $context)
	{
		if ($_SESSION['is_logged'] && $_SESSION['is_logged_admin'])
			return;
		else
			header('Location: /login');
		exit;
	}
}
