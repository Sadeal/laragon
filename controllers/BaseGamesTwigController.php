<?php

class BaseGamesTwigController extends TwigBaseController
{
	public function getContext(): array
	{
		$context = parent::getContext();

		$query1 = $this->pdo->query("SELECT DISTINCT type FROM games ORDER BY 1");
		$types = $query1->fetchAll();
		$context['types'] = $types;

		return $context;
	}
}
