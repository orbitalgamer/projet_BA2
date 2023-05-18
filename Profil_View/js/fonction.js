import {
     modal, 
    body,
    Profil
} from "./object.js"


function HideModal(){
        modal.style.display = "flex";
        body.style.backgroundColor = "#B7B4B4";
}

export {HideModal}

function closeAndConfirmModal(){
    modal.style.display = "none";
    body.style.backgroundColor = "";
    
}
function closeModal(){
    modal.style.display = "none";
    body.style.backgroundColor = "";
}
export {closeAndConfirmModal , closeModal}