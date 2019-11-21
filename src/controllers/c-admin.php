<?php
	// https://websistent.com/how-to-use-msmtp-with-gmail-yahoo-and-php-mail/
	// https://bbs.archlinux.org/viewtopic.php?id=32049

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
				if(isset($_REQUEST['mail']) && !empty($_REQUEST['mail'])) {
					$company = User::getCompany($_REQUEST['mail']);
					if(isset($company) && !empty($company)) {
						$to = $company->mail;
						$subject = 'IntershipManager Validation';
						$message = 'Cher '.$company->first_name.', '.$company->last_name.'
  Je suis le representant du site IntershipManager et en tant que dirigeant de ce groupe je vous annonce que vous etes acceptes dans le cadre de la creation de votre entreprise : '.$company->social_reason.'

  Vous pouvez desormais vous connectez ici : http://localhost/pranked
Cordialement, Representant.';
						$headers = array(
    						'From' => '',
    						'X-Mailer' => 'PHP/' . phpversion()
						);
						
						mail($to, $subject, $message, $headers);
					}
				}
			break;
		
		default:
			break;
	}
?>