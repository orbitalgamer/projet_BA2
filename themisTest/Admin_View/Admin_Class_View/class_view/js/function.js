import { titre } from "../../js/object.js";
import { addModal, headContainer, line2Icon, mainSideMenu, mainTable, menuIcon, nomAddModalInput, prenomAddModalInput, profInput, profModal, searchBar, sideMenu, tableContainer, title } from "./objet.js";

let countSearchBar = 0;//prevent bug which you click on the first time bug happend
let countSideMenu = 0;//bug
function hideSearchBar(){
  let id = null;
      let width = 20;       
      clearInterval(id)
      id = setInterval(frame2,10);
      function frame2(){
      if(searchBar.style.width == "0rem"){            
          clearInterval(id);
      }
      else{            
          width--;
          if(width > -1){
            searchBar.style.width = width + "rem";
          }
        }

      }
}

function showAndHideSearchBar(){

  if(countSearchBar > 0){
    if(searchBar.style.width == "0rem"){
      let id = null;
      let width = 0;        
      clearInterval(id);
      id = setInterval(frame1 , 10);        
      function frame1(){
           if(searchBar.style.width == "20rem"){
             clearInterval(id);
           }
           else{
            width++;
            if(width < 20){
            searchBar.style.width = width + "rem";
            }
           }
       

         }
    }
    else{
      
      let id = null;
      let width = 20;       
      clearInterval(id)
      id = setInterval(frame2,10);
      function frame2(){
      if(searchBar.style.width == "0rem"){            
          clearInterval(id);
      }
      else{            
          width--;
          if(width > -1){
            searchBar.style.width = width + "rem";
          }
        }

      }
  
    }
    
  }
  else{
    let id = null;
    let width = 0;        
    clearInterval(id);
    id = setInterval(frame1 , 10);        
    function frame1(){
         if(searchBar.style.width == "20rem"){
           clearInterval(id);
         }
         else{
          width++;
          if(width < 20){
          searchBar.style.width = width + "rem";
          }
         }
       }


       countSearchBar++;
  }
}  
export {showAndHideSearchBar};
function frameIconMenu(){
  let id = null;
  let width = 80;
  clearInterval(id);
  id = setInterval(frame3, 5);
  function frame3(){
    if( line2Icon.style.width =="50%"){
      clearInterval(id);
    }
    else{
      width--;
      if(width > 49){//same bug
        line2Icon.style.width = width + "%";
      }
     
    }
  }

}
function unframeIconMenu(){
  let id = null;
  let width = 50;
  clearInterval(id);
  id = setInterval(frame4 , 5);
  function frame4(){
    if(line2Icon.style.width =="80%"){
      clearInterval(id)
    }
    else{
      width++;
      if(width < 80){ //empecher un bug qui fait que la barre s'etend à l'infinie
        line2Icon.style.width = width + "%";
      }
     
     
    }
  }
  
}
export {frameIconMenu,unframeIconMenu}

function showAndHideSideMenu(){

  if(countSideMenu > 0){
    if(sideMenu.style.width == "5%"){
     
      let id =null;
      let width = 5;
      clearInterval(id)
      id = setInterval(frame3,10);
      function frame3(){
        if(sideMenu.style.width == "15%"){
          clearInterval(id);
        }
        else{
          width++;
          if(width < 16){
          sideMenu.style.width = width + "%";
          }
        }
      }
      headContainer.style.width ="80%";
      headContainer.style.marginLeft ="15%";
      tableContainer.style.marginLeft = "20%";
      
      mainSideMenu.style.display = "flex";
      menuIcon.style.width = "40%";
    
     
      hideSearchBar();
    }
    else{
      let id=null;
      let width = 15;
      clearInterval(id);
      id= setInterval(frame4,10)
      function frame4(){
        if(sideMenu.style.width == "5%"){
          clearInterval(id);
        }
        else{
          width--;
          sideMenu.style.width = width + "%";
        }
      }
      headContainer.style.width ="95%";
      headContainer.style.marginLeft ="0%";
      menuIcon.style.width = "80%";
      tableContainer.style.marginLeft = "";
      
      
      mainSideMenu.style.display = "none";


    }
  }
  else{
    let id =null;
      let width = 5;
      clearInterval(id)
      id = setInterval(frame3,10);
      function frame3(){
        if(sideMenu.style.width == "15%"){
          clearInterval(id);
        }
        else{
          width++;
          if(width < 16){
          sideMenu.style.width = width + "%";
          }
        }
      }
      headContainer.style.width ="80%";
      headContainer.style.marginLeft ="15%";
      mainSideMenu.style.display = "flex";
      tableContainer.style.marginLeft = "20%";
      

     
      hideSearchBar();
      countSideMenu++;
  }


}  
export {showAndHideSideMenu}
function showAndHideAddModal(){
  console.log("yes")
  if(addModal.style.display == "flex"){
   addModal.style.display = "none";
   document.querySelector("body").style.backgroundColor = "";

  }
  else{
   addModal.style.display = "flex";
   document.querySelector("body").style.backgroundColor = "gray";
  }
}
export{showAndHideAddModal}
function showAndHideAddProf(){
  console.log("yes")
  if(profModal.style.display == "flex"){
   profModal.style.display = "none";
   document.querySelector("body").style.backgroundColor = " ";

  }
  else{
   profModal.style.display = "flex";
   document.querySelector("body").style.backgroundColor = "gray";
  }
}

export {showAndHideAddProf}

function hideAddProfModal(){
  profModal.style.display = "none";
  document.querySelector("body").style.backgroundColor = "";

}
export {hideAddProfModal}

function addEleve(){
  console.log('yes')
  fetch("https://api.themistest.be/api/Enfant/Creation.php",{
    method : "POST",
    body : JSON.stringify({Token : localStorage.getItem("Token"), "Nom" : nomAddModalInput.value , "Prenom": prenomAddModalInput.value, "Annee": localStorage.getItem("AnneClasse"), "IdClasse": localStorage.getItem("IdClasse")})
  }).then(response => response.json()).then(data => console.log(data));
  showAndHideAddModal;
  window.location.reload();
}
export {addEleve}
function addProfToClasse(){
  let profInputString = profInput.value;
  const profInputStringSplit = profInputString.split(" ")
  console.log(profInputStringSplit)
  fetch("https://api.themistest.be/api/Enseignant/Affichage.php?Req="+ profInputStringSplit[0],{
    method:"POST",
    body : JSON.stringify({Token : localStorage.getItem("Token")})
  }).then(response => response.json()).then(data =>{
    console.log(data.data[0].Id)
  fetch("https://api.themistest.be/api/Groupe/Creation.php",{
    method : "POST",
    body : JSON.stringify({Token : localStorage.getItem("Token"), "Allocation": true , "IdProf": data.data[0].Id ,"IdClasse":localStorage.getItem("IdClasse")})
  }).then(response => response.json()).then(data => console.log(data))
})}


export {addProfToClasse}