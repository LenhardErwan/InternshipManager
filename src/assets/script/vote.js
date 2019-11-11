function vote(element, id_user, type) {
  
    let xhr = new XMLHttpRequest();

    let parent = element.parentNode;
    let id_article = parent.id;

    let value1 = encodeURIComponent(id_user),
        value2 = encodeURIComponent(id_article),
        value3 = encodeURIComponent(type);

    xhr.open('GET', "./assets/script/vote.php?id_user=" + value1 + "&id_hash=" + value2 + "&type=" + value3);

    xhr.addEventListener('readystatechange', function() { // On gère ici une requête asynchrone

        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) { // Si retour sans erreur
            parent.innerHTML = xhr.responseText;
        }

    });

    xhr.send(null); //On envoie la requête

}