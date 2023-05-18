import { addModalBtn } from "../../js/object.js"
import { addEleve, addProfToClasse, frameIconMenu, hideAddProfModal, showAndHideAddModal, showAndHideAddProf, showAndHideSearchBar, showAndHideSideMenu, unframeIconMenu } from "./function.js"
import { closeProfModalBtn, confirmBtnAddProfToClasse, creerBtnAddModal, exitModal, menuIcon, profModalBtn, searchBtn } from "./objet.js"

export const menuIconEvents = [
    menuIcon.addEventListener("mouseenter",frameIconMenu),
    menuIcon.addEventListener("mouseleave",unframeIconMenu),
    menuIcon.addEventListener("click",showAndHideSideMenu),
]

export const addModalEvents = [
addModalBtn.addEventListener("click",showAndHideAddModal),
exitModal.addEventListener("click",showAndHideAddModal),

]
export const profModalEvents = [
    profModalBtn.addEventListener("click",showAndHideAddProf),
    closeProfModalBtn.addEventListener("click",hideAddProfModal)
]

export const addEleveFileModalEvents = [
    
];
export const createEleveEvents = creerBtnAddModal.addEventListener("click",addEleve);
export const addProfToClasseEvents = confirmBtnAddProfToClasse.addEventListener("click",addProfToClasse)