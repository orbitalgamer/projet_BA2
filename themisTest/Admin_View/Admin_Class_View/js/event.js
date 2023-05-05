import { cancelDeleteModal, cancelModal, createClass, deleteClass, frameIconMenu, getToken, showAndHideAddModal, showAndHideSideMenu, showClassBlock, unframeIconMenu } from "./function.js";
import { addClass, addModalBtn, cancelClass, confirmSuppBtn, creerBtnAddModal, deleteDeleteModal, exitModal, id, menuIcon, nomAddModalInput } from "./object.js";

export const addModalEvents = [
 exitModal.addEventListener("click",showAndHideAddModal),
 addModalBtn.addEventListener("click",showAndHideAddModal),

 cancelClass.addEventListener("click",cancelModal)
]
export const createClasseEvents = creerBtnAddModal.addEventListener("click",createClass);

export const menuIconEvents = [ menuIcon.addEventListener("mouseenter",frameIconMenu),
 menuIcon.addEventListener("mouseleave",unframeIconMenu),
 menuIcon.addEventListener("click",showAndHideSideMenu),
]
export const deleteModalEvents = [
    deleteDeleteModal.addEventListener("click",cancelDeleteModal),
    confirmSuppBtn.addEventListener("click",deleteClass)
]
export const apiEvent = [
    getToken(),
    showClassBlock()
] 