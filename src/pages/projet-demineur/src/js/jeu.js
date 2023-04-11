class Jeu {
    constructor(probaMine) {
        this.tresor = new Tresor(Math.floor(Math.random() * 20));
        this.personnage = new Personnage(Math.floor(Math.random() * 20));
        this.carte = new Array(20);
        this.mines = [];
        for(let i = 0; i < 20; i++){
            this.carte[i] = new Array(20);
        }
        for(let i = 0; i < 20; i++){
            for(let j = 0; j < 20; j++){
                this.carte[i][j] = Math.random() < probaMine;
            }
        }
        for(let i = 0; i < 20; i++){
            for (let j = 0; j < 20; j++){
                if(i === 0){
                    if(j === this.tresor.colonne - 1 || j === this.tresor.colonne + 1 || j === this.tresor.colonne){//pour les cases gauche et droite du trésor et le trésor lui-même
                        this.carte[i][j] = false;
                    }
                }
                else if(i === 19){
                    if(j === this.personnage.colonne - 1 || j === this.personnage.colonne + 1 || j === this.personnage.colonne){//pour les mines à gauche et droite du perso et la case du perso
                        this.carte[i][j] = false;
                    }
                }
                else if(i === 18 && this.personnage.colonne === j){//pour la ligne au dessus du perso
                    this.carte[i][j] = false;
                }
                else if(i === 1 && this.tresor.colonne  === j){//pour en dessous du trésor
                    this.carte[i][j] = false;
                }
            }
        }
    }

    /**
     * Affiche toutes les mines
     */
    afficherMines() {
        for (let i = 0; i < 20 ; i++){
            for (let j = 0; j < 20; j ++){
                if(this.carte[i][j]){
                    let mine = new Mine(i, j);
                    this.mines.push(mine);
                    mine.afficher();
                }
            }
        }
    }

    /**
     * Cache toutes les mines
     */
    cacherMines() {
        for(let i = 0; i < this.mines.length; i++){
            this.mines[i].cacher();
        }
        this.mines = [];
    }

    /**
     * Renvoie le nombre de mines voisines de la position courante du joueur
     * @returns {number} nombre de mines adjacentes à la position du joueur
     */
    nbMinesVoisines() {
        let n = 0;
        if(this.personnage.colonne > 0){
            if(this.carte[this.personnage.ligne][this.personnage.colonne - 1]){
                n++;
            }
        }
        if(this.personnage.colonne < 19){
            if(this.carte[this.personnage.ligne][this.personnage.colonne + 1]){
                n++;
            }
        }
        if(this.personnage.ligne > 0){
            if(this.carte[this.personnage.ligne - 1][this.personnage.colonne]){
                n++;
            }
        }
        if(this.personnage.ligne < 19){
            if(this.carte[this.personnage.ligne + 1][this.personnage.colonne]){
                n++;
            }
        }
        return n;
    }

    /**
     * Indique si le joueur a gagné la partie
     * @returns {boolean} true si le joueur a gagné (position sur le trésor)
     */
    estGagne() {
        return this.personnage.colonne === this.tresor.colonne && this.personnage.ligne === 0;
    }

    /**
     * Indique si le joueur a perdu la partie
     * @returns {boolean} true si le joueur est positionné sur une mine ou son score est <= 0
     */
    estPerdu() {
        return this.personnage.score === 0 || this.carte[this.personnage.ligne][this.personnage.colonne];
    }
}
