import { addFichierModalEvents, addModalEvents, apiEvent, createClasseEvents, menuIconEvents } from "./event.js";

import { creerBtnAddModal, nomAddModalInput, titleProfil } from "./object.js";



addModalEvents;
menuIconEvents;
apiEvent;
createClasseEvents;
addFichierModalEvents;





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



fetch("https://api.themistest.be/api/Enseignant/Affichage.php",{
    method:"POST",
  
    body:JSON.stringify({Token: localStorage.getItem("Token")})
  }).then(response =>  response.json()).then(data => {
      console.log(data)
      
        titleProfil.innerHTML = `${data.data[0].Nom}`+' ' +`${data.data[0].Prenom}`+ `<span class="btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
          </svg>
        </span>`;
  
        
        
      });

 

