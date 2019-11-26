function vote(element, id_user, type) {
  
    let xhr = new XMLHttpRequest();

    let parent = element.parentNode.parentNode;
    let id_article = parent.id;

    let value1 = encodeURIComponent(id_article),
        value2 = encodeURIComponent(type);
    let url = window.location.href;

    url = url.replace('#','');  //Delete '#' if it contain in string

    if(url.includes("?")) url = url + "&";
    else url = url + "?";

    xhr.open('GET', url + "action=voteFor&id_hash=" + value1 + "&type=" + value2);

    xhr.addEventListener('readystatechange', function() { // On gère ici une requête asynchrone

        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) { // Si retour sans erreur
            parent.outerHTML = xhr.responseText;
        }

    });

    xhr.send(null); //On envoie la requête

}