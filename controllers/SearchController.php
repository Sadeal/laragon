<?php
require_once "BaseGamesTwigController.php";

class SearchController extends BaseGamesTwigController
{
	public $template = "search.twig";

	public function getContext(): array
	{
		$context = parent::getContext();

		$typeRu = isset($_GET['typeRu']) ? $_GET['typeRu'] : '';
		$ruName = isset($_GET['ruName']) ? $_GET['ruName'] : '';
		$info = isset($_GET['info']) ? $_GET['info'] : '';
		if ($typeRu == "Все" || $typeRu == "") {
			$sql = <<<EOL
			SELECT id, ruName, info
			FROM games
			WHERE ((:ruName = '' OR ruName like CONCAT('%', :ruName, '%')) AND (:info = '' OR info like CONCAT('%', :info, '%')))
EOL;
		} else {
			$sql = <<<EOL
			SELECT id, ruName, info
			FROM games
			WHERE ((:ruName = '' OR ruName like CONCAT('%', :ruName, '%')) AND (:info = '' OR info like CONCAT('%', :info, '%')))
				AND (typeRu = :typeRu)
EOL;
		}

		$query = $this->pdo->prepare($sql);

		$query->bindValue("ruName", $ruName);
		$query->bindValue("typeRu", $typeRu);
		$query->bindValue("info", $info);
		$query->execute();
		$context['title'] = "Поиск";
		$context['objects'] = $query->fetchAll();
		$context['searchTypeRu'] = $typeRu;
		$context['searchRuName'] = $ruName;
		$context['searchInfo'] = $info;

		$query = $this->pdo->query("SELECT * FROM types");
		$context['types'] = $query->fetchAll();

		return $context;
	}
}
