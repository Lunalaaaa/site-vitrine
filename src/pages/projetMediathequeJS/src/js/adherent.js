const listeAdh = document.getElementById("listeAdherents");
const inputButtonAdherent = document.getElementById("ajouterAdherent");
const inputAdherent = document.getElementById("nomAdherent");

class Adherent {
    constructor(id, nom) {
        this.idAdherent = id;
        this.nom = nom;
        this.emprunts = [];
    }

    /**
     * Construit et retourne un élément de liste HTML contenant les informations d'un Adhérent à afficher.
     * @returns {HTMLLIElement}
     */
    infosAdherent() {
        const adh = document.createElement("li");
        const croix = document.createElement('img');
        croix.alt = 'Supprimer';
        croix.src = 'img/x.svg';
        croix.addEventListener('click', () => {
            if (confirm("Voulez-vous vraiment supprimer cet adhérent ?")) supprimerAdherent(this.idAdherent);
        });
        const livre = document.createElement('img');
        livre.alt = 'Livre';
        livre.src = 'img/book.svg';
        livre.addEventListener('click', () => {
            callbackAfficherEmprunts(this);
        });
        const span = document.createElement("span");
        adh.innerHTML = `${this.idAdherent} - ${this.nom} `;
        if (this.emprunts.length > 0) {
            span.append(`(${this.emprunts.length} ${this.emprunts.length === 1 ? "emprunt" : "emprunts"} `);
            span.appendChild(livre);
            span.append(") ");
            adh.appendChild(span);
        }
        adh.appendChild(croix);
        return adh;
    }

    /**
     * Affiche une liste d'adhérents dans le document HTML.
     * @param {Array.<Adherent>} adh Une liste d'Adhérent.
     */
    static afficheListeAdherents(adh) {
        listeAdh.innerHTML = "";
        const liste = document.createElement("ul");
        adh.forEach(a => liste.appendChild(a.infosAdherent()));
        listeAdh.appendChild(liste);
    }
}

/**
 * Lance des requêtes pour récupérer dans la base de données les informations sur les adhérents et leurs emprunts.
 */
function getAdherentsAJAX() {
    getData(urlAdh + "?action=readAll")
        .then(adh => {
            getData(urlEmprunt + "?action=readAll")
                .then(emprunts => {
                    getData(urlLivre + "?action=readAll")
                        .then(livres => {
                            callbackAfficherAdherents(adh, emprunts, livres);
                        })
                        .catch(r => console.log(r));
                })
                .catch(r => console.log(r));
        })
        .catch(r => console.log(r));
}

/**
 * À partir d'objets JSON contenant les informations des adhérents, des emprunts et des livres,
 * cette méthode crée des objets Adhérent et des objets Livre puis afficher toutes les informations dans le HTML.
 * @param adh Objet JSON contenant tous les adhérents de la base de données
 * @param toutEmprunts Objet JSON contenant tous les emprunts de la base de données
 * @param toutLivres Objet JSON contenant tous les livres de la base de données
 */
function callbackAfficherAdherents(adh, toutEmprunts, toutLivres) {
    let adherents = [];
    adh.forEach(a => adherents.push(new Adherent(a.idAdherent, a.nomAdherent)));
    adherents.forEach(a => {
        toutEmprunts.forEach(e => {
            if (e.idAdherent === a.idAdherent) a.emprunts.push(new Livre(e.idLivre, toutLivres.find(l => l.idLivre === e.idLivre).titreLivre));
        });
    });
    Adherent.afficheListeAdherents(adherents);
}

/**
 * Enregistre un adhérent dans la base de données via une requête POST.
 * @param {String} nom Le nom d'un nouvel adhérent à enregistrer.
 */
function enregistrerAdherent(nom) {
    putData(`${urlAdh}?action=create`, `nom=${encodeURIComponent(nom)}`)
        .then(data => {
            alert(`L'adhérent d'identifiant ${data} a été ajouté !`);
            getAdherentsAJAX();
            inputAdherent.value = "";
        })
        .catch(r => console.log(r));
}

/**
 * Supprime un adhérent de la base de données via une requête GET.
 * @param {int} id Identifiant de l'adhérent à supprimer.
 */
function supprimerAdherent(id) {
    deleteData(`${urlAdh}?action=delete&id=${encodeURIComponent(id)}`)
        .then(() => {
            getAdherentsAJAX();
            getLivresAJAX();
        })
        .catch(r => console.log(r));
}

/**
 * Affiche la liste des livres empruntés par un adhérent.
 * @param {Adherent} adh L'adhérent dont on veut afficher les emprunts.
 */
function callbackAfficherEmprunts(adh) {
    const msg = document.createElement("p");
    msg.append(`${adh.nom} a emprunté :`);
    msg.setAttribute("id", "emprunts");
    const liste = document.createElement("ul");
    msg.appendChild(liste);
    adh.emprunts.forEach(elem => {
        const li = document.createElement("li");
        li.append(elem.titre);
        liste.appendChild(li);
    });
    popUp(msg);
}

inputButtonAdherent.addEventListener('click', () => {
    enregistrerAdherent(inputAdherent.value);
});