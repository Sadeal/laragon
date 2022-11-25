<?php
require_once "BaseGamesTwigController.php";

class ObjectController extends BaseGamesTwigController
{
	public $template = "__object.twig";

	public function getContext(): array
	{
		$context = parent::getContext();
		$query = $this->pdo->query("SELECT * FROM games WHERE id=" . $this->params['id']);
		$context['is_object'] = '';

		if (isset($_GET['show'])) {
			if ($_GET['show'] == 'image') {
				$this->template = "image.twig";
				$context['is_object'] = 'image';
			}
			if ($_GET['show'] == 'info') {
				$this->template = "info.twig";
				$context['is_object'] = 'info';
			}
		}

		$data = $query->fetch();
		if (!$data) {
			header('Location: /');
			exit;
		}

		$context['title'] = $data['ruName'];
		$context['urlTitle'] = $data['title'];
		$context['info'] = $data['info'];
		$context['image'] = $data['image'];
		$context['object'] = $data;
		if ($data['status'] == 'pending' && $_SESSION['user_login'] != $data['suggest']) {
			header('Location: /');
			exit;
		}


		return $context;
	}
}
