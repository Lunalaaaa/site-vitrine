/*
const urlLivre = "http://localhost/site-vitrine/src/pages/projetMediathequeJS/src/php/Controller/ControllerLivre.php";
const urlEmprunt = "http://localhost/site-vitrine/src/pages/projetMediathequeJS/src/php/Controller/ControllerEmprunt.php";
const urlAdh= "http://localhost/site-vitrine/src/pages/projetMediathequeJS/src/php/Controller/ControllerAdherent.php";
*/
const urlLivre = "https://webinfo.iutmontp.univ-montp2.fr/~kicient/site-vitrine/src/pages/projetMediathequeJS/src/php/Controller/ControllerLivre.php";
const urlEmprunt = "https://webinfo.iutmontp.univ-montp2.fr/~kicient/site-vitrine/src/pages/projetMediathequeJS/src/php/Controller/ControllerEmprunt.php";
const urlAdh= "https://webinfo.iutmontp.univ-montp2.fr/~kicient/site-vitrine/src/pages/projetMediathequeJS/src/php/Controller/ControllerAdherent.php";
const urlAPI = "https://www.googleapis.com/books/v1/volumes";

/**
 * Renvoie une Promise qui contient le résultat d'une requête GET.
 * @param {String} url L'URL de la requête à exécuter.
 * @returns {Promise<unknown>} Le résultat de la requête.
 */
function getData(url) {
    return new Promise((resolve, reject) => {
        fetch(url)
            .then(rep => rep.json())
            .then(data => resolve(data))
            .catch(error => reject(error));
    });
}

/**
 * Renvoie une Promise d'une requête GET pour supprimer des données.
 * @param {String} url L'URL de la requête à exécuter.
 * @returns {Promise<unknown>} Le résultat qui peut être renvoyé.
 */
function deleteData(url) {
    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', url);
        xhr.onload = () => {
            if (xhr.status === 200 && xhr.responseText.length > 0) {
                const data = JSON.parse(xhr.responseText);
                resolve(data);
            } else if (xhr.status !== 200) reject(`${xhr.status} : ${xhr.responseText}`);
            else resolve();
        }
        xhr.send();
    });
}

/**
 * Renvoie une Promise d'une requête POST.
 * @param {String} url L'URL de la requête à exécuter.
 * @param {String} params Les paramètres de la requête sous la forme urlencoded.
 * @returns {Promise<unknown>} Le résultat de la requête.
 */
function putData(url, params) {
    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', url);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
        xhr.onload = () => {
            if (xhr.status === 200 && xhr.responseText.length > 0) {
                const data = JSON.parse(xhr.responseText);
                resolve(data);
            } else if (xhr.status !== 200) reject(`${xhr.status} : ${xhr.responseText}`);
            else resolve();
        }
        xhr.send(params);
    });
}
