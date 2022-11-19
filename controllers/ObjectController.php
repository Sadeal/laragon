<?php
require_once "BaseGamesTwigController.php";

class ObjectController extends BaseGamesTwigController
{
	public $template = "__object.twig"; // указываем шаблон

	public function getContext(): array
	{
		$context = parent::getContext();
		$query = $this->pdo->query("SELECT * FROM games WHERE id=" . $this->params['id']);

		if (isset($_GET['show'])) {
			if ($_GET['show'] == 'image') {
				$this->template = "image.twig";
			}
			if ($_GET['show'] == 'info') {
				$this->template = "info.twig";
			}
		}

		// готовим запрос к БД, допустим вытащим запись по id=2
		// тут уже указываю конкретные поля, там более грамотно
		// стягиваем одну строчку из базы
		$data = $query->fetch();

		// передаем описание из БД в контекст
		$context['title'] = $data['ruName'];
		$context['urlTitle'] = $data['title'];
		$context['info'] = $data['info'];
		$context['image'] = $data['image'];
		$context['object'] = $data;


		return $context;
	}
}
