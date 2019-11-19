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
?>