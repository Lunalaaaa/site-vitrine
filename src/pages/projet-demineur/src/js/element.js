class Element {

    constructor(ligne, colonne, spriteURL) {
        if(this.constructor !== Element){
            this.ligne = ligne;
            this.colonne = colonne;
            this.img = document.createElement("img");
            this.img.setAttribute("src", spriteURL);
            this.img.className = "element";
            this.placer(ligne, colonne);
        }
        else{
            throw new TypeError("Non instanciable.");
        }
    }

    /**
     * Déplace l'élément à la position indiquée (et replace le sprite pour qu'il soit affiché au bon endroit)
     * @param ligne {Number} indice de la ligne où placer l'élément
     * @param colonne {Number} indice de la colonne où placer l'élément
     */
    placer(ligne, colonne) {
        this.ligne = ligne;
        this.colonne = colonne;
        this.img.style.top = (51 + (20 * ligne)) + "px";
        this.img.style.left = (51 + (20 * colonne)) + "px";
    }

    /**
     * Affiche l'élément
     * Ajoute l'élément (= la balise) dans le <div id="champ">
     */
    afficher() {
        let div = document.getElementById("champ");
        div.appendChild(this.img);
    }

    /**
     * Cache l'élément
     * Supprime l'élément du <div id="champ">
     */
    cacher() {
        let div = document.getElementById("champ");
        div.removeChild(this.img);
    }
}


class Tresor extends Element {
    constructor(colonne) {
        super(0, colonne, "img/tresor.png");
    }
}


class Mine extends Element {
    constructor(ligne, colonne) {
        super(ligne, colonne, 'img/croix.png');
    }
}


class Personnage extends Element {
    constructor(colonne) {
        super(19, colonne, 'img/personnage.png');
        this.score = 200;
    }

    /**
     * Exécute un déplacement du joueur horizontalement ou verticalement des valeurs passées en paramètre.
     * Si le déplacement est valide (le joueur ne sort pas de la grille 20x20), la position du personnage est modifiée
     * et le score est décrémenté de 1.
     *
     * Prérequis : exactement un des deux paramètres `dl` et `dc` est non nul, et sa valeur est 1 ou -1.
     * @param dl {Number} déplacement vertical du joueur (modifie la ligne)
     * @param dc {Number} déplacement horizontal du joueur (modifie la colonne)
     */
    deplacer(dl, dc) {
        if(this.ligne + dl <= 19 && this.ligne + dl >= 0 && this.colonne + dc <= 19 && this.colonne + dc >= 0){
            this.placer(this.ligne + dl, this.colonne + dc);
            this.score -= 1;
        }
    }

    /**
     * Met à jour le sprite (= l'image) du personnage
     * On doit afficher l'image alternative si il y a une mine dans une case voisine
     * @param nbMinesVoisines {Number} nombre de mines dans les cases voisines
     */
    majSprite(nbMinesVoisines) {
        if(nbMinesVoisines >= 1){
            this.img.setAttribute("src", "img/personnage2.png");
        }
        else{
            this.img.setAttribute("src", "img/personnage.png");
        }
    }
}