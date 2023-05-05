import { 
  searchBar ,
  line2Icon,
  menuIcon,
  sideMenu,
  headContainer,
  mainContainer,
  mainSideMenu,
  tableContainer,
  blockContainer,
  mainSideMenu768px,
  sideMenu768px,
  headContainer768px,
  searchBar768px,
  infoPageText,
  twoLine768px,
  titre,
  mainTable
} 
from "./button.js";







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
      blockContainer.style.marginRight = "5rem";

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
      blockContainer.style.marginRight = "15rem";
      hideSearchBar();
      countSideMenu++;
  }


}  
export {showAndHideSideMenu}

/*--------------------------------------Mobile devices-----------------------------*/
let countSearchBar768px = 0;//prevent bug which you click on the first time bug happend
let countSideMenu768px = 0;//bug

function showAndHideSideMenu768px(){
  if(countSideMenu768px > 0){
    if(sideMenu768px.style.width == "10%"){
     
      let id =null;
      let width = 10;
      clearInterval(id)
      id = setInterval(frameOpen,10);
      function frameOpen(){
        if(sideMenu768px.style.width == "25%"){
          clearInterval(id);
        }
        else{
          width++;
          if(width < 25){
          sideMenu768px.style.width = width + "%";
          }
        }
      }
      mainSideMenu768px.style.display = "flex";
      headContainer768px.style.width = "120%";
      infoPageText.style.marginLeft = "30%";


      

      
    }
    else{
      let id=null;
      let width = 25;
      clearInterval(id);
      id= setInterval(frameClose,10)
      function frameClose(){
        if(sideMenu768px.style.width == "10%"){
          clearInterval(id);
        }
        else{
          width--;
          sideMenu768px.style.width = width + "%";
        }
      }
      
      mainSideMenu768px.style.display = "none";
      headContainer768px.style.width = "100%";
      infoPageText.style.marginLeft = "0%";

  
    }
  }
  else{
    let id =null;
      let width = 10;
      clearInterval(id)
      id = setInterval(frame3,10);
      function frame3(){
       if(sideMenu768px.style.width == "25%"){
          clearInterval(id);
        }
        else{
          width++;
          if(width < 25){
          sideMenu768px.style.width = width + "%";
          }
        }
      }
      mainSideMenu768px.style.display = "flex";
      headContainer768px.style.width = "120%";
      infoPageText.style.marginLeft = "30%";

      
      countSideMenu768px++;
      
  }


}
export {showAndHideSideMenu768px}

function showAndHideSearchBar768px(){ 
  if(countSearchBar768px > 0){
    //when sideMenu is closed
    if(searchBar768px.style.width == "0rem" & mainSideMenu768px.style.display == "none"){
      let id = null;
      let width = 0;        
      clearInterval(id);
      id = setInterval(frame1 , 10);        
      function frame1(){
           if(searchBar768px.style.width == "20rem"){
             clearInterval(id);
           }
           else{
            width++;
            if(width < 20){
            searchBar768px.style.width = width + "rem";
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
      if(searchBar768px.style.width == "0rem"){            
          clearInterval(id);
      }
      else{            
          width--;
          if(width > -1){
            searchBar768px.style.width = width + "rem";
          }
          
          searchBar768px.style.backgroundColor = "13293D";
          }
      }
    }
    //when sideMenu is opened
    if(searchBar768px.style.width == "0rem" & mainSideMenu768px.style.display == "flex"){
      let id = null;
      let width = 0;        
      clearInterval(id);
      id = setInterval(frame1 , 10);        
      function frame1(){
           if(searchBar768px.style.width == "15rem"){
             clearInterval(id);
           }
           else{
            width++;
            if(width < 15){
            searchBar768px.style.width = width + "rem";
            }
           }
         }

    }
    else{
      let id = null;
      let width = 15;       
      clearInterval(id)
      id = setInterval(frame2,10);
      function frame2(){
      if(searchBar768px.style.width == "0rem"){            
          clearInterval(id);
      }
      else{            
          width--;
          if(width > -1){
            searchBar768px.style.width = width + "rem";
          }
          
          searchBar768px.style.backgroundColor = "13293D";
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
         if(searchBar768px.style.width == "20rem"){
           clearInterval(id);
         }
         else{
          width++;
          if(width < 20){
          searchBar768px.style.width = width + "rem";
          }
         }
       }
       countSearchBar768px++;
       
  }
}


export {showAndHideSearchBar768px}
function frameIconMenu768px(){ 
  let id = null;
  let width = 80;
  clearInterval(id);
  id = setInterval(frame3, 5);
  function frame3(){
    if( twoLine768px.style.width =="50%"){
      clearInterval(id);
    }
    else{
      width--;
      if(width > 49){//same bug
        twoLine768px.style.width = width + "%";
      }
     
    }
  }

}
function unframeIconMenu768px(){
  let id = null;
  let width = 50;
  clearInterval(id);
  id = setInterval(frame4 , 5);
  function frame4(){
    if(twoLine768px.style.width =="100%"){
      clearInterval(id)
    }
    else{
      width++;
      if(width < 100){ //empecher un bug qui fait que la barre s'etend à l'infinie
        twoLine768px.style.width = width + "%";
      }
    }
  }
  
}
export {frameIconMenu768px,unframeIconMenu768px}


//--------------------------api-----------

function getToken(){  
  
  fetch("https://api.themistest.be/api/Connection/Connection.php",{
    method:"POST",
    headers:{
        'Content-Type':'application/json'
    },
    body:JSON.stringify({'Identifiant':'nom.prenom','Mdp':'test'})
 }).then(response => response.json()).then(data => {
  console.log(data)
    localStorage.setItem('Token',data.data.Token);
   })

}
export {getToken}

function showClass(){
  fetch("https://api.themistest.be/api/Groupe/Affichage.php",{
    method:"POST",
    body :JSON.stringify({Token : localStorage.getItem("Token"),"IdClasse":"All"})
  }).then(response => response.json()).then(data => {
   for(let i=0 ; i < data.data.length ; i++){
    const newClasse = document.createElement("a");
    newClasse.setAttribute("class","row");
    newClasse.setAttribute("href","https://api.themistest.be/api/Groupe/Affichage.php?")
    newClasse.textContent = data.data[i].Nom;

    mainTable.appendChild(newClasse);
   }


  });
}