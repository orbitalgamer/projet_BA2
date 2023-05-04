import { addModalEvents, addProfToClasseEvents, createEleveEvents, menuIconEvents, profModalEvents, searchBarEvents } from "./event.js";
import { mainTable,   profInput,   searchProfOutput,   title} from "./objet.js";

searchBarEvents;
menuIconEvents;
addModalEvents;
createEleveEvents;
addProfToClasseEvents;
profModalEvents;
const id = {
    'Identifiant':"nom.prenom",
    'Mdp':"test"
}

fetch("https://api.themistest.be/api/Connection/Connection.php",{
    method:"POST",
    headers : {
        "Content-type":"application/json"
    },
    body: JSON.stringify(id)
}).then(response => response.json()).then(data =>{

    localStorage.setItem("Token",data.data.Token);
})


function getTest(text){
  
    window.location.href = "./test_view/test.html?value=" + encodeURIComponent(text);
  }
  var params = new URLSearchParams(location.search);
  let classParams = decodeURIComponent(params.get("Classe"))
  const classParamsSplit = classParams.split(" ");
 
  
  
  if(classParamsSplit[0].toUpperCase() === "CLASSE"){
    classParamsSplit.shift();
  }
  

  console.log(classParamsSplit)
  title.textContent = "Classe " +  classParamsSplit[0]
  localStorage.setItem("AnneClasse",classParamsSplit[0])
  

  
fetch("https://api.themistest.be/api/Groupe/Affichage.php?Req="+classParamsSplit[0],{
      method:"POST",
      body:JSON.stringify({Token:localStorage.getItem("Token")})
    }).then(response => response.json()).then(data => {
    localStorage.setItem("IdClasse",data.data[0].Id);
fetch("https://api.themistest.be/api/Groupe/Affichage.php",{
    method:"POST",
    body: JSON.stringify({Token : localStorage.getItem("Token"),"IdProf":"None","IdClasse":data.data[0].Id,"Eleve":true})
  }).then(response => response.json()).then(data =>{
    console.log(data)
    //showStudents();
    const idRow = [ "num" ,"nom", "prenom" , "test"];
    let count = 0 ;
    while(count < data.data.Enfant.length){
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
    console.log(data.data.Enfant[count].Nom);
    newElementRowContainer[0].innerHTML = `${count+1}`
    newElementRowContainer[1].innerHTML = `${data.data.Enfant[count].Nom}`;
    newElementRowContainer[2].innerHTML = `${data.data.Enfant[count].Prenom}`;
    const TestBtn = document.createElement("button");
    TestBtn.textContent = "Testez-le";
    TestBtn.setAttribute("href","../test_view/test.html")
    
    //fonction pour aller sur l'interface test et avoir le nom de l'èlève
    const textToSend = data.data.Enfant[count].Nom + " " + data.data.Enfant[count].Prenom;
    newElementRowContainer[3].appendChild(TestBtn);
    TestBtn.addEventListener("click",()=>{getTest(textToSend)})
    count++;
    }
    })
})  



let previousRow = false;
profInput.addEventListener("input",()=>{

  
    const newSearchString =  profInput.value;
    
    fetch("https://api.themistest.be/api/Enseignant/Affichage.php?Req="+newSearchString,{
    method:"POST",
    body:JSON.stringify({Token:localStorage.getItem("Token")})
  }).then(response => response.json()).then(data => {
    console.log(data)
    
     if(data.message == "succes" & newSearchString != ""){
      if(previousRow == true){
      document.querySelectorAll(".Row").forEach(row => {
        row.remove();
      })
    }  
      for(let i=0 ; i < data.data.length;i++){
          const newRow =  document.createElement("div");
          newRow.setAttribute("class","Row");
          newRow.textContent = data.data[i].Nom + " " + data.data[i].Prenom;
          newRow.addEventListener("click",()=>{
          profInput.value = newRow.textContent;
            
          })
          searchProfOutput.appendChild(newRow);
          previousRow = true;
      }
      
    }else if(newSearchString == "" && previousRow == true){
      document.querySelectorAll(".Row").forEach(row => {
        row.remove();
      })
    }
    
                      
  })  
  
  })
  window.addEventListener("click", function(event) {
    if (event.target != profInput) {
      searchProfOutput.style.display = "none";
    }
  });

  window.addEventListener("click",function(event){
    if(event.target === profInput){
      searchProfOutput.style.display = "flex";
    }
  })
   

  fetch("https://api.themistest.be/api/Groupe/Affichage.php",{
    method:"POST",
    body:JSON.stringify({Token : localStorage.getItem("Token"),"IdProf":"All","IdClasse":"All","Eleve":true})
  }).then(response => response.json()).then(data =>console.log(data))