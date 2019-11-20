<?php
	function getAdminArticles() {
		$articles = Article::getAllArticles();

		foreach ($articles as $article) {
			$article->mission = substr($article->mission, 0, 90).'...';
			$article->social_reason = User::getCompanyName($article->id_company);
		}

		return $articles;
	}

	function getAdminMembers() {
		return User::getAllMembers();
	}

	function getAdminCompanies() {
		return User::getAllCompanies();
	}

	$action = (isset($_REQUEST['action']) ? $_REQUEST['action'] : '');

	switch ($action) {
		case 'validate':
				$id = (isset($_REQUEST['id']) ? $_REQUEST['id'] : '');

				$to      = 'admin@example.com';
				$subject = 'Compte a valider';
				$message = 'Le compte portant l\'adresse mail : '.$result['mail'].' doit etre valide.';
				$headers = array(
    				'From' => 'webmaster@example.com',
    				'X-Mailer' => 'PHP/' . phpversion()
				);

				mail($to, $subject, $message, $headers);
			break;
		
		default:
			break;
	}
?>