/** @type {Jeu} jeu */
let jeu;  // variable globale représentant le jeu actuel

document.addEventListener("keydown", function (event) {
    if(!jeu.estPerdu() && !jeu.estGagne()){
        switch (event.key) {
            case 'ArrowLeft':
                jeu.personnage.deplacer(0, -1);
                miseAJour();
                break;
            case 'ArrowUp':
                jeu.personnage.deplacer(-1, 0);
                miseAJour();
                break;
            case 'ArrowRight':
                jeu.personnage.deplacer(0, 1);
                miseAJour();
                break;
            case 'ArrowDown':
                jeu.personnage.deplacer(1, 0);
                miseAJour();
                break;
            case 'A':
                setTimeout(() => {}, 2000);
                jeu.afficherMines();
                if(jeu.personnage.score > 50){
                    jeu.personnage.score = jeu.personnage.score - 50;
                }
                else{
                    jeu.personnage.score = 0;
                }
                miseAJour();
                setTimeout(() => {  jeu.cacherMines() }, 1000);
                break;
            default:
        }
    }
});



/**
 * Met à jour la partie et l'affichage pour le joueur en fonction de la position du joueur
 * - indique si la partie est gagnée ou perdue
 * - indique le nombre de mines à proximité du joueur
 * - affiche le score du joueur
 * - met à jour l'image représentant le joueur
 */
function miseAJour() {
    let score = document.getElementById("score")
    score.innerHTML = "Score : " + jeu.personnage.score;
    jeu.personnage.majSprite(jeu.nbMinesVoisines());
    let mines = document.getElementById("message");
    if(jeu.estGagne()){
        mines.textContent = "Gagné !";
        jeu.afficherMines();
    }
    else if(jeu.estPerdu()){
        mines.textContent = "Perdu !";
        jeu.afficherMines();
    }
    else{
        mines.textContent = "Mines à proximité : " + jeu.nbMinesVoisines();
    }
}


/**
 * Démarre une nouvelle partie
 */
function nouvellePartie() {
    if(typeof jeu !== 'undefined'){
        jeu.personnage.cacher();
        jeu.tresor.cacher();
        jeu.cacherMines();
    }
    jeu = new Jeu(0.5);
    jeu.personnage.afficher();
    jeu.tresor.afficher();
    this.miseAJour();
}


window.addEventListener("load", function () {
    nouvellePartie();
});

let button = document.getElementById("nouvelle-partie");
button.addEventListener("click", function(){
    nouvellePartie();
});