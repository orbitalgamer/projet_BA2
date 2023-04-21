//--------------------------button-----------------------------------------------------
export const submit = document.querySelector(".sauvegarder");
export const confirmerBtn = document.querySelector("#confirmer");
export const closeIcon = document.querySelector(".closeIcon");
export const annulerBtn = document.querySelector("#annuler");
//-------------------------Objects-DOM----------------------------------------------------
export const modal = document.querySelector(".modal");
export const body = document.querySelector("body");
export let inputNomValue = document.querySelector("#Nom");
export let inputPrenomValue = document.querySelector("#Prenom");
export let inputEmailValue = document.querySelector("#Email");
export let inputMdpValue = document.querySelector("#mdp");
export let inputConfirmMdpValue = document.querySelector("#confirmMdp");
export const arrow = document.querySelector(".arrow");

//--------------------------Objects--------------------------------------------
export  function Profil(nom,prenom,email,mdp){
    this.nom = nom;
    this.prenom = prenom;
    this.email = email;
    this.mdp = mdp;
}