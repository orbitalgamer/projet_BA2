
const idToConnect  ={
  "Identifiant":"nom.prenom",
  "Mdp":"test"
}
const token = "";
fetch("https://api.themistest.be/api/Connection/Connection.php",{
  method:'POST',
  headers:{
    'Content-Type':'application/json'
  },
  body:JSON.stringify(idToConnect)
}).then(response => response.json()).then(Data => {
  console.log(Data)
  localStorage.setItem("Token",Data.data.Token) ;
  

})
let idEleve = -1;
const eleveInput = document.querySelector("#eleve");
const searchEleveOutput = document.querySelector("#searchEleve");

let previousRow = false;

eleveInput.addEventListener("input",()=>{

  
  const newSearchString =  eleveInput.value;
  
  fetch("https://api.themistest.be/api/Enfant/Affichage.php?Req="+newSearchString,{
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
          eleveInput.value = newRow.textContent;
          
        })
        searchEleveOutput.appendChild(newRow);
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
  if (event.target != searchEleveOutput) {
    searchEleveOutput.style.display = "none";
  }
});

window.addEventListener("click",function(event){
  if(event.target === eleveInput){
    searchEleveOutput.style.display = "flex";
  }
})
 
const testInput = document.querySelector("#test");
const searchTestOutput = document.querySelector("#searchTest");
const testArray = ["TDA","Dyslexie","Dysorthophonie"]

testInput.addEventListener("input",()=>{

  
  const newSearchString =  testInput.value;
  
 
 
  
    for(let i=0 ; i < testArray.length;i++){
        const newRow =  document.createElement("div");
        newRow.setAttribute("class","Row");
        newRow.textContent = testArray[i];  
        newRow.addEventListener("click",()=>{
          testInput.value = newRow.textContent;
        })
        searchTestOutput.appendChild(newRow);
        previousRow = true;
    }
  
  if(newSearchString == "" && previousRow == true){
    document.querySelectorAll(".Row").forEach(row => {
      row.remove();
    })
  }
    
  })  



window.addEventListener("click", function(event) {
  if (event.target != searchTestOutput) {
    searchTestOutput.style.display = "none";
  }
});

window.addEventListener("click",function(event){
  if(event.target === testInput){
    searchTestOutput.style.display = "flex";
  }
})

















let runnig = false;
let score = 0;
let count = 1;
let selectedValue = "";//initialiser globalement pour éviter de double-cliquer 
let currentEleve = "";
let currentText = "";

  const questions = [
    {
      question: "Avez-vous déjà fumé de la cigarette ?",
      scoreOui: 1,
      scoreNon: -1
    },
    {
      question: "Avez-vous déjà eu des problèmes de santé mentale ?",
      scoreOui: 2,
      scoreNon: -2
    },
    {
      question: "Avez-vous déjà eu des antécédents familiaux de maladies cardiaques ?",
      scoreOui: 1,
      scoreNon: -1
    },
    {
      question: "Avez-vous une alimentation équilibrée ?",
      scoreOui: -1,
      scoreNon: 1
    },
    {
      question: "Avez-vous déjà eu des problèmes de sommeil ?",
      scoreOui: 2,
      scoreNon: -2
    },
    {
      question: "Avez-vous déjà eu des problèmes de dos ?",
      scoreOui: 1,
      scoreNon: -1
    },
    {
      question: "Avez-vous des antécédents familiaux de cancer ?",
      scoreOui: 1,
      scoreNon: -1
    },
    {
      question: "Avez-vous déjà eu des problèmes de peau ?",
      scoreOui: 1,
      scoreNon: -1
    },
    {
      question: "Avez-vous une activité physique régulière ?",
      scoreOui: -2,
      scoreNon: 2
    },
    {
      question: "Avez-vous déjà eu des problèmes de vue ?",
      scoreOui: 1,
      scoreNon: -1
    },
    {
      question: "Avez-vous une consommation régulière d'alcool ?",
      scoreOui: 2,
      scoreNon: -2
    },
    {
      question: "Avez-vous déjà eu des problèmes d'allergie ?",
      scoreOui: 1,
      scoreNon: -1
    },
    {
      question: "Avez-vous des antécédents familiaux de diabète ?",
      scoreOui: 1,
      scoreNon: -1
    },
    {
      question: "Avez-vous déjà eu des problèmes de respiration ?",
      scoreOui: 2,
      scoreNon: -2
    },
    {
      question: "Avez-vous déjà eu des problèmes de digestion ?",
      scoreOui: 1,
      scoreNon: -1
    },
    {
      question: "Avez-vous une consommation régulière de tabac ?",
      scoreOui: 2,
      scoreNon: -2
    },
    {
      question: "Avez-vous déjà eu des problèmes de circulation sanguine ?",
      scoreOui: 1,
      scoreNon: -1
    },
    {
      question: "Avez-vous déjà eu des problèmes d'audition ?",
      scoreOui: 1,
      scoreNon: -1
    },
    {
      question: "Avez-vous des antécédents familiaux de maladies respiratoires ?",
      scoreOui: 1,
      scoreNon: -1
    },
    {
      question: "Avez-vous déjà eu des problèmes d'infection urinaire ?",
      scoreOui: 1,
      scoreNon : -1
    }
]
  

const response = ["Oui","Non"];
const reponseSaved = [];
const infoTest = document.querySelector("h1");
const inputContainer = document.querySelector(".inputContainer");
const confirmBtn = document.querySelector("#confirmBtn");
const resBtn = document.querySelector("#resBtn");
const labelInput = document.querySelectorAll(".labelInput");
const btnContainer =   document.querySelector(".btnContainer");
function clearBoard(){
  //suppression/changement des elements existants
  labelInput.forEach(label => label.style.display = "none");
  confirmBtn.remove();  
  resBtn.remove()
  inputContainer.style.flexDirection = "row";
  inputContainer.style.justifyContent = "center";
  inputContainer.style.columnGap = "5%";
  if(runnig){
    resBtn.remove()
  }
  
  
  //creation des nouveaux labels et radio input
  infoTest.style.fontSize = "3rem";
  for(let i = 0 ; i < response.length; i++){
  let responseString = response[i];
  console.log(responseString);
  const checkLabel = document.createElement("Label");
  checkLabel.setAttribute("class","reponse")
  checkLabel.setAttribute("for",responseString);
  checkLabel.textContent= responseString;
  //radio input creation
  const checkInput = document.createElement("input");
  checkInput.setAttribute("class","reponse")
  checkInput.setAttribute("type","radio");
  checkInput.setAttribute("id",responseString);
  checkInput.setAttribute("name","radio");
  checkInput.setAttribute("value",responseString);
  checkLabel.appendChild(checkInput);
  inputContainer.appendChild(checkLabel);
  }
  //creation precedent btn
  const previousBtn = document.createElement("button");
  previousBtn.setAttribute("class","submitBtn");
  previousBtn.setAttribute("id","previousBtn");
  previousBtn.textContent = "Precedent"
  btnContainer.appendChild(previousBtn);
  previousBtn.addEventListener("click",previousQuestion);
  //creation suivant btn
  const nextBtn = document.createElement("button");
  nextBtn.setAttribute("class","submitBtn");
  nextBtn.setAttribute("id","nextBtn");
  nextBtn.textContent = "Suivant";
  btnContainer.appendChild(nextBtn);
  nextBtn.addEventListener("click",checkResponse)
  //suppr confirmBtn et resBtn:
  confirmBtn.remove();
  resBtn.remove();
  infoTest.textContent = questions[0].question;

}





function gameRunning(){
  
  if(resBtn.clicked ==  true){
    console.log('yes');
  }

}


function gameStart(){
  
 
   currentEleve = eleveInput.value;
   currentText = testInput.value;
   console.log(idEleve)

  
  clearBoard();
 
}
function getRadioValue(name) {
  const radios = document.getElementsByName(name);

  for (let i = 0; i < radios.length; i++) {
    if (radios[i].checked) {
      return radios[i].value;
    }
  }

  return null; // aucun radio n'est checké
}
function getRatio(score){
  score += 19;
  score = score/38;
  score = score*100;
  console.log(score);
  if(score >= 70){
    return "Des troubles dys potentielles existent";  
  }
  else if( 50 <= score && score < 70 ){
    return "L'enfant n'a pas de dys potentielle, cependant l'enfant doit être quand même suivie";

    
  }
  else if(score < 50) {
    return "L'enfant n'a aucune trace de trouble dys detecté";
  }
}

function checkResponse(){ 
  if(count < questions.length){
  
  selectedValue = getRadioValue("radio");
  reponseSaved.push(selectedValue);
  if(selectedValue == "Oui"){
    score += questions[count].scoreOui
    nextQuestion()
  }
  else{
    score += questions[count].scoreNon
    nextQuestion()  
  }
 

  }
  else{
    endGame();
  }

}

function nextQuestion(){ 
  infoTest.innerHTML = `${questions[count].question}`;
  count++;
}

function previousQuestion(){
  const checkInput = document.querySelectorAll(".response");
  if(selectedValue == "oui"){
  score = score - questions[count].scoreOui;
   
  }
  else if(selectedValue == "non"){
    score = score - questions[count].scoreNon;
    
  }
  else if (count == 0){
    location.reload()
  }
  count--;
  infoTest.innerHTML = `${questions[count].question}`;
}

function endGame(){
  const inputRadio = document.querySelectorAll(".reponse");
  inputRadio.forEach((radio)=>{
    radio.remove();
  })//supprimer tous les elements qui ont été créer precedemment
  inputContainer.style.height = "60%";
  previousBtn.remove();
  nextBtn.remove();
  //afficher le layout 
  
  resBtn.textContent = "Envoyer les résultats";
  btnContainer.style.position = "relative";
  btnContainer.style.top = "-2%";
  
  const sendRes = document.createElement("button");
  sendRes.setAttribute("class","submitBtn");
  sendRes.setAttribute("id","sendRes");
  sendRes.textContent = "Envoyez les résultats";
  btnContainer.appendChild(sendRes);


  //afficher le score
  let resultat = getRatio(score);
  infoTest.innerHTML = `${resultat}`;
  infoTest.style.fontSize = "3rem";


  sendRes.addEventListener("click",()=>{
    fetch("https://api.themistest.be/api/Test/Creation.php",{
      method : "POST",
      headers : {
        'Content-Type':'application/json'
      },
      body:JSON.stringify({Token: localStorage.getItem("Token"),})
    })
    location.reload();
  })

    
}

confirmBtn.addEventListener("click",gameStart)




var params = new URLSearchParams(location.search);
document.querySelector("#eleve").value = decodeURIComponent(params.get("value"));
if(decodeURIComponent(params.get("value")) == "null"){
  document.querySelector("#test").value = "";
}