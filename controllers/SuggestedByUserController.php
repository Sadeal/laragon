<?php
require_once "BaseGamesTwigController.php";

class SuggestedByUserController extends BaseGamesTwigController
{
	public $template = "suggestedByUser.twig";
	public $title = "Предложения";

	public function getContext(): array
	{
		$context = parent::getContext();
		$sql = <<<EOL
SELECT *
FROM games
WHERE status = 'pending'
AND suggest = :suggest
EOL;
		$query = $this->pdo->prepare($sql);
		$query->bindValue("suggest", $_SESSION['user_login']);
		$query->execute();
		$context['suggestions'] = $query->fetchAll();

		return $context;
	}
}
