import {
  arrowEvents,
    modalEvents,
    
} from "./event.js"
import { Profil,
    inputNomValue,
  inputPrenomValue,
  inputEmailValue,
  inputMdpValue,
  inputConfirmMdpValue
       } from "./object.js";


fetch("http://127.0.0.1:8000/profil/").then(response => response.json()).then(data => {

  inputNomValue.value = `${data.nom}`;
  inputPrenomValue.value = `${data.prenom}`;
  inputEmailValue.value = `${data.email}`;
  inputMdpValue.value = `${data.mdp}`;
  inputConfirmMdpValue.value = `${data.mdp}`
})
  

modalEvents;
arrowEvents;