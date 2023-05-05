import { 
    sideMenuEvents,
} from "./event.js";
import { mainTable, title } from "./object.js";



function getTest(text){
  
  window.location.href = "./test_view/test.html?value=" + encodeURIComponent(text);
}


fetch("https://api.themistest.be/api/Connection/Connection.php",{
  method:"POST",
  headers:{
    'Content-Type':'application/json'
  },
  body:JSON.stringify(id)
}).then(response => {
    if(response.status == "200"){
        title.innerHTML = `${id.Identifiant}` + `<span class="btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
      </svg>
    </span>`;
    }
    else{
        return;
    }
    
    return response.json()})
    .then(Data => {
    console.log(Data)
  fetch("https://api.themistest.be/api/Enfant/Affichage.php?Id=All",{
    method:"POST",
    body: JSON.stringify({Token : Data.data.Token})
  }).then(response => response.json()).then(data =>{
    console.log(data)
    //showStudents();
    const idRow = [ "num" ,"nom", "prénom" , "test"];
    let count = 0 ;
    while(count < data.data.length){
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
    console.log(data.data[count].Nom);
    newElementRowContainer[0].innerHTML = `${count+1}`
    newElementRowContainer[1].innerHTML = `${data.data[count].Nom}`;
    newElementRowContainer[2].innerHTML = `${data.data[count].Prenom}`;
    const TestBtn = document.createElement("button");
    TestBtn.textContent = "Testez-le";
    
    //fonction pour aller sur l'interface test et avoir le nom de l'èlève
    const textToSend = data.data[count].Nom + " " + data.data[count].Prenom;
    newElementRowContainer[3].appendChild(TestBtn);
    TestBtn.addEventListener("click",()=>{getTest(textToSend)})
    count++;
    }
    })
    
})



sideMenuEvents;
