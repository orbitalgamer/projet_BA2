const navButton = document.querySelector("#btn");

const closeButton = document.querySelector("#closeBtn");

function openNav(){
    document.getElementById("side").style.display = "flex";

    
    document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
    document.querySelector(".sideBarBtnContainer").style.display = "none";

}
function closeNave(){

    document.getElementById("side").style.display = "none";
    document.body.style.backgroundColor = "white";
    document.querySelector(".sideBarBtnContainer").style.display = "block";

    
  
}
navButton.addEventListener("click", openNav)
closeButton.addEventListener("click", closeNave)
