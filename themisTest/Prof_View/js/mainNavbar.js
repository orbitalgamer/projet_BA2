const mainContainer= document.querySelector(".mainContainer");
const iconBtn = document.querySelector(".btn");
const close = document.querySelector(".bi-x");
const downMenuBtn = document.querySelector(".downMenuBtn");
const downMenu = document.querySelector(".downMenu");
let open = false;


function showModal(){

        mainContainer.style.display = "flex"
}
function hideModal(){
    mainContainer.style.display = "none";
}

function showAndHideMenu(){
    

    if(open == false){
        downMenu.style.display = "flex";
        downMenu.style.position = "absolute";
        open = true;
      }
      else{
        downMenu.style.display = "none";
        downMenu.style.position = "none";
        open = false;
      }
}
  

downMenuBtn.addEventListener("click",showAndHideMenu);
iconBtn.addEventListener("click",showModal);
close.addEventListener("click",hideModal)
