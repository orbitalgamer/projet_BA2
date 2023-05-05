import { addModalEvents, apiEvent, createClasseEvents, menuIconEvents } from "./event.js";
import { createClass } from "./function.js";
import { creerBtnAddModal, nomAddModalInput } from "./object.js";



addModalEvents;
menuIconEvents;
apiEvent;
createClasseEvents;
let token = localStorage.getItem("Token");
console.log(token)





creerBtnAddModal.addEventListener("click",()=>{
  fetch("https://api.themistest.be/api/Groupe/Creation.php",{
    method:"POST",
    body: JSON.stringify({Token : localStorage.getItem("Token"), "Allocation":false, "Nom": nomAddModalInput.value})
   }).then(response => response.json()).then(data=> console.log(data))
})

fetch("https://api.themistest.be/api/Groupe/Affichage.php",{
  method:"POST",
 
  body: JSON.stringify({Token : localStorage.getItem("Token"), "IdClasse":"All","IdProf":"All","Eleve":"false"})
}).then(response=>response.json()).then(data =>{
console.log(data);
})





 

