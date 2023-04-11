window.onload = () => {
    getAdherentsAJAX();
    getLivresAJAX();
}

/**
 * Affiche un pop up.
 * @param {HTMLElement} elem Un élément à afficher dans le Pop-Up
 */
function popUp(elem) {
    const divKill = document.getElementById("lockPage");
    const divPopUp = document.createElement("div");
    divPopUp.setAttribute("id", "popup");
    const croix = document.createElement("img");
    croix.id = "croix";
    croix.alt = "Fermer";
    croix.src = "img/x.svg";
    croix.addEventListener('click', () => {
        document.body.removeChild(divPopUp);
        divKill.style.visibility = "hidden";
    });
    divPopUp.appendChild(croix);
    divPopUp.appendChild(elem);
    divKill.style.visibility = 'visible';
    document.body.insertBefore(divPopUp, document.querySelector("h2"));
}