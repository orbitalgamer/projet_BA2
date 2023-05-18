import { cancelAddFichier, cancelDeleteModal, cancelModal, createClass, deleteClass, frameIconMenu, sendFile, showAndHideAddFichier, showAndHideAddModal, showAndHideSideMenu, showClassBlock, unframeIconMenu } from "./function.js";
import {  addFichierModalBtn, addModalBtn, cancelAddModal, cancelClass, confirmSuppBtn, creerBtnAddModal, deleteDeleteModal, exitModal, id, menuIcon, nomAddModalInput, sendFileBtn } from "./object.js";

export const addModalEvents = [
deleteDeleteModal.addEventListener("click",showAndHideAddModal),
 addModalBtn.addEventListener("click",showAndHideAddModal),
  cancelAddModal.addEventListener("click",cancelModal)
 
]
export const createClasseEvents = creerBtnAddModal.addEventListener("click",createClass);

export const addFichierModalEvents = [
    addFichierModalBtn.addEventListener("click",showAndHideAddFichier),
    sendFileBtn.addEventListener('click',sendFile),
    document.querySelector(".biFichier").addEventListener("click",cancelAddFichier)
]



export const menuIconEvents = [ menuIcon.addEventListener("mouseenter",frameIconMenu),
 menuIcon.addEventListener("mouseleave",unframeIconMenu),
 menuIcon.addEventListener("click",showAndHideSideMenu),
]
export const deleteModalEvents = [
    deleteDeleteModal.addEventListener("click",cancelDeleteModal),
    confirmSuppBtn.addEventListener("click",deleteClass)
]
export const apiEvent = [
 
    showClassBlock()
] 


