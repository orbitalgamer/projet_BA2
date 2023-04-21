const id = {
  "Identifiant":"nom.prenom",
  "Mdp":"test"
}

import { 
 mainContainer,
 downMenu,
 nom,
 prenom,
 test,
 num,

 mainTable
    
} from "./object.js";


let open = false;


function showModal(){

        mainContainer.style.display = "flex"
}
export {showModal}
function hideModal(){
    mainContainer.style.display = "none";
}
export {hideModal}

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
export {showAndHideMenu}

function showStudents(data){

    const idRow = [ "num" ,"nom", "prenom" , "test"];
    let count = 0 ;
    while(count < data.length){
    const newElementRowContainer =  [];
    const newRow  =  document.createElement("div");
    newRow.setAttribute("class","row");
  
    mainTable.appendChild(newRow);
    
    for(let j = 0 ; j  < idRow.length; j++){
        const newElementRow = document.createElement("div");
        newElementRow.setAttribute("class", "elementRow");
        newElementRow.setAttribute("id", idRow[j]);
        newElementRowContainer.push(newElementRow);
        newRow.appendChild(newElementRow)
        console.log('ok');
    }
    console.log(data[count].nom);
    newElementRowContainer[0].innerHTML = `${count+1}`
    newElementRowContainer[1].innerHTML = `${data[count].nom}`;
    newElementRowContainer[2].innerHTML = `${data[count].prenom}`;
    const TestBtn = document.createElement("button");
    TestBtn.textContent = "Testez-le";
    newElementRowContainer[3].appendChild(TestBtn);
    count++;
    }
    }
 

export {showStudents}