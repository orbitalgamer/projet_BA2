

import{ 
searchBar,
line2Icon,
sideMenu,
headContainer,
mainContainer,
mainSideMenu,
menuIcon,
tableContainer,
blockContainer,
addModal,
id,
inputProfTxt,
inputClassTxt,
deleteModal,
nomAddModalInput,
confirmSuppBtn,
addFichierModal
 }
from './object.js'



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
  export{hideSearchBar}
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
   export {showAndHideSearchBar}
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
   
 export{frameIconMenu,unframeIconMenu} 
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
        mainContainer.style.marginLeft = "15%";
        mainSideMenu.style.display = "flex";
        menuIcon.style.width = "40%";
        tableContainer.style.marginLeft = "8%";
        blockContainer.style.marginRight = "15rem";
       
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
        mainContainer.style.marginLeft = "0%";
        mainSideMenu.style.display = "none";
        menuIcon.style.width = "80%";
        
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
        mainContainer.style.marginLeft = "15%";
        mainSideMenu.style.display = "flex";
        menuIcon.style.width = "40%";

        countSideMenu++;
    }
  
  
  }  
export{showAndHideSideMenu}
  function showAndHideAddModal(){
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
function cancelModal(){
  console.log("yes")

    if(addModal.style.display == "flex"){
      addModal.style.display = "none";
      document.querySelector("body").style.backgroundColor = "";

     }
     else return;
     
  
}
export {cancelModal};
let currentClassBlock //string that now when you click on a class which class is it
function showAndHideDeleteModal(event){
  currentClassBlock = event.target.id;
  if(deleteModal.style.display == "flex"){
    deleteModal.style.display = "none";
    document.querySelector("body").style.backgroundColor = "";

   }
   else{
    deleteModal.style.display = "flex";
    document.querySelector("body").style.backgroundColor = "gray";
    
   }
}
export {showAndHideDeleteModal}
function cancelDeleteModal(){
  if(deleteModal.style.display == "flex"){
    deleteModal.style.display = "none";
    document.querySelector("body").style.backgroundColor = "";

   }
   else return;

}
export {cancelDeleteModal}
//-------------------------------------------api function-------------------------------------------------

  function getRows(nbr){
     nbr = Math.ceil(nbr/3);
     let nbrRow = []
     for(let i = 1 ; i <= nbr; i++){
        let row = `${i}/${i+1}`; 
        nbrRow.push(row);
     }
     return nbrRow;

    }
    function getColumns(nbr){
       
       let numberColumns = [];
       if(nbr > 3){
        numberColumns.push("1/2","2/3","3/4")
 
       }
       else
       for(let i = 1 ; i <= nbr ; i++){
          let row  = `${i}/${i+1}`;
          numberColumns.push(row);
       }
       return numberColumns;
    }

  

function showClassBlock(){
  fetch("https://api.themistest.be/api/Groupe/Affichage.php",{
    method:"POST",
   
    body: JSON.stringify({Token : localStorage.getItem("Token"), "IdClasse":"All","IdProf":"All","Eleve":"false"})
}).then(response=>response.json()).then(data =>{
  console.log(data);
  
  let count = 0;
  let nbr = data.data.length;
  let numberRows = getRows(data.data.length);
  
  while(nbr > 0){
     
      for(let i = 0 ; i < numberRows.length ; i++){
        console.log(count)
        let numberColumns = getColumns(nbr);
        console.log(numberColumns);
        console.log(numberRows)
             
       for(let j = 0 ; j < numberColumns.length ; j++){ 
        let classBlock = document.createElement("a");
        classBlock.setAttribute("class","classBlock");
        classBlock.style.gridRow = numberRows[i]
        classBlock.style.gridColumn = numberColumns[j];
        
        
        document.querySelector(".mainMainContainer").appendChild(classBlock);
         //create a btn to acces to the class
         let accesClassBtn = document.createElement("a");
         accesClassBtn.setAttribute("class","textClassBox")
         accesClassBtn.setAttribute("href" , "./class_view/class.html?Classe="+ data.data[count].Nom)
         accesClassBtn.textContent = `${data.data[count].Nom}`;
         classBlock.appendChild(accesClassBtn)
       //create a btn to delete the class
        let deleteClassBtn = document.createElement("button");
        //to give to deleteClass the id of the block you've clicked
        const dataNomClasseSplit = data.data[count].Nom.split(" ");
        let dataNomOfDeleteBtn = " ";
        if(dataNomClasseSplit.length <= 1){
          dataNomOfDeleteBtn = dataNomClasseSplit[0]
        }
        else{
          dataNomOfDeleteBtn =  dataNomClasseSplit[1];
        }
        deleteClassBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" id=${dataNomOfDeleteBtn} class="bi bi-x" viewBox="0 0 16 16">
        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
      </svg>`;
        deleteClassBtn.style.border = "none";
        deleteClassBtn.style.backgroundColor = "aliceblue"; 
        deleteClassBtn.style.position = "relative";
        deleteClassBtn.style.left = "30%";
        deleteClassBtn.style.bottom = "40%";
        deleteClassBtn.addEventListener("click",showAndHideDeleteModal)
        classBlock.appendChild(deleteClassBtn)
        

        count++;
       }
      nbr = nbr - 3;

              
       
      }
      
          
  }

  

  })
}

function createClass(){
 
 fetch("https://api.themistest.be/api/Groupe/Creation.php",{
  method:"POST",
  body: JSON.stringify({Token : localStorage.getItem("Token"), "Allocation":false, "Nom": nomAddModalInput.value})
 }).then(response => response.json()).then(data=> console.log(data))
 showAndHideAddModal;
 window.location.reload();
}

function deleteClass(){
  //trouver l'id du block classe où on vient de cliquer
  
  console.log(currentClassBlock);
  fetch("https://api.themistest.be/api/Groupe/Affichage.php?Req="+currentClassBlock,{
    method:"POST",
    body:JSON.stringify({Token:localStorage.getItem("Token")})
  }).then(response => response.json()).then(data => {
    console.log(data.data[0].Id)
   fetch("https://api.themistest.be/api/Groupe/Suppression.php",{
    method:"POST",
    body:JSON.stringify({Token : localStorage.getItem("Token"),"Desalouer":false, "IdClasse": data.data[0].Id})
   }).then(response => response.json()).then(data => {
    console.log(data);
     window.location.reload()})
  })

}

export {showClassBlock,createClass,deleteClass}

function showAndHideAddFichier(){
  console.log("yes")
  if(addFichierModal.style.display == "flex"){
   addFichierModal.style.display = "none";
   document.querySelector("body").style.backgroundColor = "";

  }
  else{
   addFichierModal.style.display = "flex";
   document.querySelector("body").style.backgroundColor = "gray";
  }
}

function cancelAddFichier(){

    if(addFichierModal.style.display == "flex"){
      addFichierModal.style.display = "none";
      document.querySelector("body").style.backgroundColor = "";
    }
    else{
      return
    }
}
export {showAndHideAddFichier,cancelAddFichier}

function sendFile(){
var input = document.querySelector("#fichier")
 var data = new FormData()
                //console.log(...input.files)
  data.append('Fichier', input.files[0])
  data.append('Token', localStorage.getItem("Token"))                
  fetch('https://api.themistest.be/api/Enfant/Import.php', {
                method: 'POST',
                body: data,
                }).then(response => {
                return response.json();
                }).then(Data=>{
                console.log(Data)
                input.value = "";
                })
              }
export {sendFile}