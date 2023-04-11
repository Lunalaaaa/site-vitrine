const divLivreDispos = document.getElementById('listeLivresDisponibles');
const divLivreEmprunts = document.getElementById('listeLivresEmpruntes');
const inputButtonLivre = document.getElementById("ajouterLivre");
const inputLivre = document.getElementById("titreLivre");

class Livre {
    constructor(idLivre, titreLivre) {
        this.idLivre = idLivre;
        this.titre = titreLivre;
    }

    /**
     * Construit un élément `li` dans lequel on renseigne les informations d'un livre et les différentes
     * actions liées à ce livre
     *
     * @param {boolean} emprunt indique si le livre est emprunté
     * @returns {HTMLLIElement}
     */
    infosLivre(emprunt = false) {
        const li = document.createElement('li');
        const img = document.createElement('img');
        img.src = 'img/image.svg';
        img.alt = 'image';
        img.addEventListener('click', () => {
            recupererCouverture(this.titre).then();
        });
        const croix = document.createElement("img");
        croix.alt = "Supprimer";
        croix.src = "img/x.svg";
        croix.addEventListener('click', () => {
            if (confirm("Voulez-vous vraiment supprimer ce livre ?")) supprimerLivre(this.idLivre);
        });
        const span = document.createElement("span");
        const adh = document.createElement("img");
        adh.alt = 'adherent';
        adh.src = 'img/person.svg';
        span.addEventListener('click', () => {
            if (!emprunt) callbackEmprunter(this).then();
            else callbackRendreLivre(this);
        });
        adh.addEventListener("click", () => {
            afficherEmprunteur(this);
        });
        span.append(`${this.idLivre} - ${this.titre} `);
        li.appendChild(span);
        if (emprunt) {
            li.appendChild(adh);
            li.append(" ");
        }
        li.appendChild(img);
        li.append(" ");
        li.appendChild(croix);
        return li;
    }

    /**
     * affiche les livres disponibles dans la div listeLivresDisponibles
     *
     * @param {Array.<Livre>} dispos liste des livres disponibles à l'emprunt
     */
    static afficherLivresDispos(dispos) {
        divLivreDispos.innerHTML = "";
        const livresDispo = document.createElement('ul');
        dispos.forEach(l => livresDispo.appendChild(l.infosLivre()));
        divLivreDispos.appendChild(livresDispo);
    }

    /**
     * affiche les livres dispos dans la div listeLivresEmpruntes
     *
     * @param {Array.<Livre>} empruntes liste des livres empruntés
     */
    static afficherLivresEmpruntes(empruntes) {
        divLivreEmprunts.innerHTML = "";
        const livresEmprunts = document.createElement('ul');
        empruntes.forEach(livre => livresEmprunts.appendChild(livre.infosLivre(true)));
        divLivreEmprunts.appendChild(livresEmprunts);
    }
}

/**
 * permet de faire la requête pour récuperer des informations sur les livres empruntés et disponibles.
 */
function getLivresAJAX() {
    getData(urlLivre + "?action=readAll")
        .then(livres => {
            getData(urlEmprunt + "?action=readAll")
                .then(emprunts => callbackAfficherLivres(livres, emprunts))
                .catch(r => console.log(r));
        })
        .catch(r => console.log(r));
}

/**
 * permet de faire la mise à jour entre les livres empruntés et disponibles et de les afficher dans le HTML.
 *
 * @param livres Objet JSON qui renvoie la liste des livres
 * @param emprunts Objet JSON qui renvoie la liste des livres empruntés
 */
function callbackAfficherLivres(livres, emprunts) {
    let books = [];
    let empruntes = [];
    livres.forEach(l => books.push(new Livre(l.idLivre, l.titreLivre)));
    emprunts.forEach(l => {
        const index = books.findIndex(e => e.idLivre === l.idLivre);
        const book = books[index];
        empruntes.push(book);
        books.splice(index, 1);
    });
    Livre.afficherLivresDispos(books);
    Livre.afficherLivresEmpruntes(empruntes);
}

/**
 * créer un livre dans la base de données
 *
 * @param titre String titre du livre à ajouter
 */
function enregistrerLivre(titre) {
    putData(`${urlLivre}?action=create`, `titre=${encodeURIComponent(titre)}`)
        .then(data => {
            alert(`Le livre d'identifiant ${data} a bien été ajouté.`);
            getLivresAJAX();
            inputLivre.value = "";
        })
        .catch(r => console.log(r));
}

/**
 * Supprime un livre de la base de données.
 *
 * @param {int} id identifiant du livre à supprimer
 */
function supprimerLivre(id) {
    deleteData(`${urlLivre}?action=delete&id=${encodeURIComponent(id)}`)
        .then(() => {
            getLivresAJAX();
            //si le livre supprimé est emprunté par un adhérent
            getAdherentsAJAX();
        })
        .catch(r => console.log(r));
}

/**
 * permet d'emprunter un livre
 *
 * @param idLivre identifiant du livre à emprunter
 * @param idAdh identifiant de l'adhérent emprunteur
 */
function emprunterLivre(idLivre, idAdh) {
    putData(`${urlEmprunt}?action=create`, `idAdherent=${encodeURIComponent(idAdh)}&idLivre=${encodeURIComponent(idLivre)}`)
        .then(() => {
            getLivresAJAX();
            getAdherentsAJAX();
        })
        .catch(r => console.log(r));
}

/**
 * permet de rendre un livre.
 *
 * @param idLivre identifiant du livre à rendre
 */
function rendreLivre(idLivre) {
    deleteData(`${urlEmprunt}?action=delete&idLivre=${encodeURIComponent(idLivre)}`)
        .then(() => {
            getLivresAJAX();
            getAdherentsAJAX();
        })
        .catch(r => console.log(r));
}

/**
 * permet de faire l'appel à la base de données pour emprunter un livre.
 *
 * @param {Livre} livre objet livre à emprunter
 */
async function callbackEmprunter(livre) {
    let idAdh = Number(window.prompt(`Veuillez entrer l'identifiant de l'adhérent qui empruntera \"${livre.titre}\"`));
    if (idAdh) {
        try {
            const data = await (await fetch(`${urlAdh}?action=readAll`)).json();
            const ids = data.map(a => a.idAdherent);
            if (ids.findIndex(i => i === idAdh) !== -1) emprunterLivre(livre.idLivre, idAdh);
            else alert("Cet identifiant d'adhérent n'existe pas ! ");
        } catch (e) {
            console.log(e);
        }
    }
}

/**
 * permet d'afficher la fenêtre de confirmation pour rendre un livre.
 *
 * @param {Livre} livre objet Livre à rendre
 */
function callbackRendreLivre(livre) {
    if (window.confirm("Retour de ce livre ?")) {
        rendreLivre(livre.idLivre);
    }
}

/**
 * récupere des informations sur l'emprunteur du livre.
 *
 * @param {Livre} livre objet livre emprunté
 */
function afficherEmprunteur(livre) {
    getData(`${urlEmprunt}?action=readAll`)
        .then(data => {
            const emprunt = data.find(l => l.idLivre === livre.idLivre);
            if (emprunt) {
                getData(urlAdh + "?action=readAll")
                    .then(adh => {
                        callbackAfficherEmprunteur(adh, emprunt);
                    })
                    .catch(r => console.log(r));
            } else alert("Ce livre n'a pas été emprunté.");
        })
        .catch(r => console.log(r));
}

/**
 * permet de récupérer les données des emprunteurs.
 *
 * @param {Adherent} adh objet adherent qui emprunte le livre
 * @param {Array<Livre>} emprunt liste des livres empruntés
 */
function callbackAfficherEmprunteur(adh, emprunt) {
    const adherent = adh.find(a => a.idAdherent === emprunt.idAdherent);
    if (adherent) {
        const emprunteur = new Adherent(adherent.idAdherent, adherent.nomAdherent);
        const msg = document.createElement("p");
        msg.append(`Ce livre a été emprunté par ${emprunteur.nom}.`);
        popUp(msg);
    }
}

inputButtonLivre.addEventListener('click', () => {
    enregistrerLivre(inputLivre.value);
});

/**
 * permet de faire la requête à l'API Google Books pour trouver la couverture d'un livre
 *
 * @param {String} titre titre du livre
 */
async function recupererCouverture(titre) {
    try {
        const data = await (await fetch(`${urlAPI}?q=${encodeURIComponent(titre)}`)).json();
        callbackCouverture(data);
    } catch (e) {
        console.log(e);
    }
}

/**
 * permet de trier le JSON pour en extraire la couverture et l'afficher
 *
 * @param data Objet JSON avec toutes les données renvoyées par l'API
 */
function callbackCouverture(data) {
    if (data !== null) {
        const filtered = data.items.filter(i => i.volumeInfo.imageLinks !== undefined);
        let url = filtered[0].volumeInfo.imageLinks.smallThumbnail;
        let img = document.createElement('img');
        img.src = url;
        img.alt = "Couverture";
        img.classList.add("couverture");
        popUp(img);
    } else {
        let p = document.createElement('p');
        p.classList.add("couverture");
        p.innerHTML = 'Image non disponible';
        popUp(p);
    }
}