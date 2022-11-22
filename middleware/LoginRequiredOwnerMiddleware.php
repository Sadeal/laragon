<?php

class LoginRequiredOwnerMiddleware extends BaseMiddleware
{
	public function apply(BaseController $controller, array $context)
	{
		if ($_SESSION['is_logged'] && $_SESSION['is_logged_admin'] && $_SESSION['is_logged_owner'])
			return;
		else
			header('Location: /login');
		exit;
	}
}
