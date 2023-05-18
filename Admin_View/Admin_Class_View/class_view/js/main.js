
import { addModalEvents, addProfToClasseEvents, createEleveEvents, menuIconEvents, profModalEvents } from "./event.js";
import { mainTable,   profInput,   searchProfOutput,   title, titleProfil} from "./objet.js";

menuIconEvents;
addModalEvents;
createEleveEvents;
addProfToClasseEvents;
profModalEvents;










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