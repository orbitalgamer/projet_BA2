
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
 

















let runnig = false;
let score = 0;
let count = 0;
let nbrQuestion = 0;
let mainCount = 0;
let selectedValue = "";//initialiser globalement pour éviter de double-cliquer 
let currentEleve = "";
let currentText = "";
let resultat = [];

const Dysorthographique = [
{
  questionsPrincipale :  "L'élève fait des fautes d'orthographes fréquentes",

  questionsSecondaire : [
    {
      question: "Lors de l’ECRITURE, l’élève écrit un mot de différentes façons sur un même paragraphe ou une même ligne (ex : téritoir et territtoire)",
      answers: [
        { text: "Pas du tout", score: 0 },
        { text: "Un petit peu", score: 1 },
        { text: "Beaucoup", score: 2 },
        { text: "Enormément", score: 3 }
      ]
    },
    {
      question: "Lors de L’ECRITURE, l’élève inverse des lettres et syllabes (comme écrire « volé » pour « vélo »)",
      answers: [
        { text: "Pas du tout", score: 0 },
        { text: "Un petit peu", score: 1 },
        { text: "Beaucoup", score: 2 },
        { text: "Enormément", score: 3 }
      ]
    },
    {
      question: "Lors de L’ECRITURE, l’élève oublie des lettres, des syllabes ou des lettres (comme écrire « conporain» pour « contemporain» ou « live» pour « livre»)",
      answers: [
        { text: "Pas du tout", score: 0 },
        { text: "Un petit peu", score: 1 },
        { text: "Beaucoup", score: 2 },
        { text: "Enormément", score: 3 }
      ]
    },
    {
      question: "Lors de L’ECRITURE l’élève substitue des lettres, des mots, des sons proches lors de l’écriture (comme écrire « la belle maman » pour « la belle maison »)",
      answers: [
        { text: "Pas du tout", score: 0 },
        { text: "Un petit peu", score: 1 },
        { text: "Beaucoup", score: 2 },
        { text: "Enormément", score: 3 }
      ]
    },
    {
      question: "Lors de L’ECRITURE, l’élève raccourcit ou allonge des mots (comme écrire « alamère » pour « à la mer » ou « au par avant » pour « auparavant»)",
      answers: [
        { text: "Pas du tout", score: 0 },
        { text: "Un petit peu", score: 1 },
        { text: "Beaucoup", score: 2 },
        { text: "Enormément", score: 3 }
      ]
    },
    {
      question: "Lors de L’ECRITURE, l’élève fait des erreurs de découpage des mots (comme « lent de main » pour « lendemain »)",
      answers: [
        { text: "Pas du tout", score: 0 },
        { text: "Un petit peu", score: 1 },
        { text: "Beaucoup", score: 2 },
        { text: "Enormément", score: 3 }
      ]
    }
  ]
} ,
{

  questionsPrincipale : " ",
  questionsSecondaire : [
    
      {
         question: "Lors de l’ECOUTE, l’élève confond les sons proches (comme /p/, /t/, /b/ ou /d/)",
        answers: [
          { text: "Pas du tout", score: 0 },
          { text: "Un petit peu", score: 1 },
          { text: "Beaucoup", score: 2 },
          { text: "Enormément", score: 3 },
        ],
      },
      {
        question: "Lors de la LECTURE, l’élève confond visuellement les lettres similaires (comme lire p et d, p et q, m et n, n et u, m et w, f et t)",
        answers: [
          { text: "Pas du tout", score: 0 },
          { text: "Un petit peu", score: 1 },
          { text: "Beaucoup", score: 2 },
          { text: "Enormément", score: 3 },
        ],
      },
      {
        question: "De manière GENERALE, l’élève mélange les temps : l’élève a du mal avec la concordance des temps",
        answers: [
          { text: "Pas du tout", score: 0 },
          { text: "Un petit peu", score: 1 },
          { text: "Beaucoup", score: 2 },
          { text: "Enormément", score: 3 },
        ],
      },

        {
          question: "L’élève a du mal à faire plusieurs tâches en même temps",
          answers: [
            { text: "Pas du tout", score: 0 },
            { text: "Un petit peu", score: 1 },
            { text: "Beaucoup", score: 2 },
            { text: "Enormément", score: 3 },
          ],
        },
        {
          question: "L’élève arrive a bien rester concentré au cours",
          answers: [
            { text: "Pas du tout", score: 3 },
            { text: "Un petit peu", score: 2 },
            { text: "Beaucoup", score: 1 },
            { text: "Enormément", score: 0 },
          ],
        },
        {
          question: "L’élève a un retard de langage et de parole",
          answers: [
            { text: "Pas du tout", score: 0 },
            { text: "Un petit peu", score: 1 },
            { text: "Beaucoup", score: 2 },
            { text: "Enormément", score: 3 },
          ],
        },
        {
          question: "L’élève fait beaucoup de ratures et il est difficile de déchiffrer son écriture",
          answers: [
            { text: "Pas du tout", score: 0 },
            { text: "Un petit peu", score: 1 },
            { text: "Beaucoup", score: 2 },
            { text: "Enormément", score: 3 },
          ],
        },
        {
          question: "L’élève a difficile de s’autocorriger",
          answers: [
            { text: "Pas du tout", score: 0 },
            { text: "Un petit peu", score: 1 },
            { text: "Beaucoup", score: 2 },
            { text: "Enormément", score: 3 },
          ],
        },
        {
          question: "L’élève est hyperactif",
          answers: [
            { text: "Pas du tout", score: 0 },
            { text: "Un petit peu", score: 1 },
            { text: "Beaucoup", score: 2 },
            { text: "Enormément", score: 3 },
          ],
        },
    
      
    
    
  ]
},
{
  questionsPrincipale : " ",
  questionsSecondaire : [{
    question : "L'élève a du mal lors de la lecture",
    answers: [
      { text: "Pas du tout", score: 0 },
      { text: "Un petit peu", score: 1 },
      { text: "Beaucoup", score: 2 },
      { text: "Enormément", score: 3 }
    ]
  }]
},
{
  questionsPrincipale : " ",
  questionsSecondaire : [{
    question : "L'élève a du mal dans la production de textes",
    answers: [
      { text: "Pas du tout", score: 0 },
      { text: "Un petit peu", score: 1 },
      { text: "Beaucoup", score: 2 },
      { text: "Enormément", score: 3 }
    ]
  }
  ]
}
]
const Dyslexie = [
  {
    questionsPrincipale : "Lors de l'ECRITURE, l'élève éprouve des difficultés au niveau de l'orthographe",
    questionsSecondaire : [
      [  {    "text": "Lors de l'ECRITURE, l'élève éprouve de la difficulté dans l'écriture de mots familiers",   
       "answers": [      { "text": "Pas du tout", "score": 0 },      { "text": "Un petit peu", "score": 1 },      { "text": "Beaucoup", "score": 2 },      { "text": "Enormément", "score": 3 }    ]
  },
  {
    "text": "Lors de l’ECRITURE, l’élève raccourcit ou allonge des mots (comme écrire « alamère » pour « à la mer » ou «au par avant» pour « auparavant»)",
    "answers": [
      { "text": "Pas du tout", "score": 0 },
      { "text": "Un petit peu", "score": 1 },
      { "text": "Beaucoup", "score": 2 },
      { "text": "Enormément", "score": 3 }
    ]
  }
]

    ]
  }, 
  {
    questionsPrincipale : "Lors de la LECTURE, l’élève a du mal à lire de façon fluide un texte",
    questionsSecondaire : [
      {    question: "Lors de la LECTURE, l’élève ajoute des lettres et syllabes (comme lire « plateau » au lieu de «plat»)",    answers: [      { label: "Pas du tout", score: 0 },      { label: "Un petit peu", score: 1 },      { label: "Beaucoup", score: 2 },      { label: "Énormément", score: 3 }    ]
    },
    {
      question: "Lors de la LECTURE, l’élève inverse lors des lettres ou des syllabes (comme lire « volé » pour « vélo »)",
      answers: [
        { label: "Pas du tout", score: 0 },
        { label: "Un petit peu", score: 1 },
        { label: "Beaucoup", score: 2 },
        { label: "Énormément", score: 3 }
      ]
    },
    {
      question: "Lors de la LECTURE, l’élève confond les lettres similaires (comme p et d, p et q, m et n, n et u, m et w, f et t)",
      answers: [
        { label: "Pas du tout", score: 0 },
        { label: "Un petit peu", score: 1 },
        { label: "Beaucoup", score: 2 },
        { label: "Énormément", score: 3 }
      ]
    },
    {
      question: "Lors de la LECTURE, l’élève lit de manière lente et hachée",
      answers: [
        { label: "Pas du tout", score: 0 },
        { label: "Un petit peu", score: 1 },
        { label: "Beaucoup", score: 2 },
        { label: "Énormément", score: 3 }
      ]
    },
    {
      question: "Lors de la LECTURE, l’élève enlève des lettres et syllabes (comme lire « conporain» au lieu de « contemporain» ou « lire » au lieu de « livre »)",
      answers: [
        { label: "Pas du tout", score: 0 },
        { label: "Un petit peu", score: 1 },
        { label: "Beaucoup", score: 2 },
        { label: "Énormément", score: 3 }
      ]
    },
    {
      question: "Lors de la LECTURE, l’élève substitue des lettres (comme lire « la belle maman » au lieu de « la belle maison »)",
      answers: [
        { label: "Pas du tout", score: 0 },
        { label: "Un petit peu", score: 1 },
        { label: "Beaucoup", score: 2 },
        { label: "Énormément", score: 3 }
      ]
    },
    {
      question: "Lors de la LECTURE, l’élève saute des mots ou des lignes",
      answers: [
        { label: "Pas du tout", score: 0 },
        { label: "Un petit peu", score: 1 },
        { label: "Beaucoup", score: 2 },
        { label: "Énormément", score: 3 }
      ]
    },
    {
      question: "Lors de la LECTURE, l'élève éprouve des difficultés dans l'identification précise des mots familiers",
      answers : [
        { label: "Pas du tout", score: 0 },
        { label: "Un petit peu", score: 1 },
        { label: "Beaucoup", score: 2 },
        { label: "Énormément", score: 3 }
      ]
  
    }
      
    ]
  },  
  {
    questionsPrincipale : " ",
    questionsSecondaire : [
      {
      question: "L'élève a du mal à produire des textes",
      answers: [
        { score: 0, text: "Pas du tout" },
        { score: 1, text: "Un petit peu" },
        { score: 2, text: "Beaucoup" },
        { score: 3, text: "Enormément" },
      ]
    }
    ]
  },
  {
    questionsPrincipale : " ",
    questionsSecondaire : [
      
      {
        question: "L'élève a des difficultés pour se repérer dans l'espace et le temps",
        answers: [
          { score: 0, text: "Pas du tout" },
          { score: 1, text: "Un petit peu" },
          { score: 2, text: "Beaucoup" },
          { score: 3, text: "Enormément" },
        ],
      },
      {
        question: "Lors de l’ECOUTE, l’élève confond les sons proches (comme /p/, /t/, /b/ ou /d/)",
        answers: [
          { score: 0, text: "Pas du tout" },
          { score: 1, text: "Un petit peu" },
          { score: 2, text: "Beaucoup" },
          { score: 3, text: "Enormément" },
        ],
      },
    ]
  },
  {
    questionsPrincipale : " ",
    questionsSecondaire : [
     
        {
          question: "Lors de la LECTURE, l’élève a du mal à comprendre les consignes",
          answers: [
            { text: "Pas du tout", score: 0 },
            { text: "Un petit peu", score: 1 },
            { text: "Beaucoup", score: 2 },
            { text: "Enormément", score: 3 }
          ]
        },
        {
          question: "Lors de la LECTURE, l’élève a du mal à comprendre le contenu, le sens de ce qui a été lu",
          answers: [
            { text: "Pas du tout", score: 0 },
            { text: "Un petit peu", score: 1 },
            { text: "Beaucoup", score: 2 },
            { text: "Enormément", score: 3 }
          ]
        },
        {
          question: "Lors de l’ECRITURE, L’élève écrit un mot de différentes façon sur un même paragraphe ou une même ligne (ex : ortografe et aurtaugraffe)",
          answers: [
            { text: "Pas du tout", score: 0 },
            { text: "Un petit peu", score: 1 },
            { text: "Beaucoup", score: 2 },
            { text: "Enormément", score: 3 }
          ]
        }
   
      
    ]
  }
 
]
const TDA = [{
   questionsPrincipale : " ",
   questionsSecondaire : [ {
      question: "L’élève est facilement distrait durant le cours",
      answers: [
        { score: 0, text: "Pas du tout" },
        { score: 1, text: "Un petit peu" },
        { score: 2, text: "Beaucoup" },
        { score: 3, text: "Enormément" }
      ]
    },
    {
      question: "L’élève est rêveur",
      answers: [
        { score: 0, text: "Pas du tout" },
        { score: 1, text: "Un petit peu" },
        { score: 2, text: "Beaucoup" },
        { score: 3, text: "Enormément" }
      ]
    },
    {
      question: "L’élève se laisse mener par les autres",
      answers: [
        { score: 0, text: "Pas du tout" },
        { score: 1, text: "Un petit peu" },
        { score: 2, text: "Beaucoup" },
        { score: 3, text: "Enormément" }
      ]
    },
    {
      question: "L’élève éprouve des difficultés d’apprentissage",
      answers: [
        { score: 0, text: "Pas du tout" },
        { score: 1, text: "Un petit peu" },
        { score: 2, text: "Beaucoup" },
        { score: 3, text: "Enormément" }
      ]
    },
    {
      question: "L’élève perd souvent ses affaires (matériel scolaire, portefeuille, clés, lunettes..)",
      answers: [
        { score: 0, text: "Pas du tout" },
        { score: 1, text: "Un petit peu" },
        { score: 2, text: "Beaucoup" },
        { score: 3, text: "Enormément" }
      ]
    },
    {
      question: "L’élève oublie souvent les tâches qu’il a à faire",
      answers: [
        { score: 0, text: "Pas du tout" },
        { score: 1, text: "Un petit peu" },
        { score: 2, text: "Beaucoup" },
        { score: 3, text: "Enormément" }
      ]
    },
    {
      question: "L’élève ne semble pas écouter, même quand on lui parle personnellement",
      answers: [
        { score: 0, text: "Pas du tout" },
        { score: 1, text: "Un petit peu" },
        { score: 2, text: "Beaucoup" },
        { score: 3, text: "Enormément" }
      ]
    },
    {
      question: "L’élève est impoli, impertinent",
      answers: [
        { score: 0, text: "Pas du tout" },
        { score: 1, text: "Un petit peu" },
        { score: 2, text: "Beaucoup" },
        { score: 3, text: "Enormément" }
      ]
    },
    {
      question: "L’élève porte attention à ce qui l’intéresse vraiment",
      answers: [
        { response: "Pas du tout", score: 0 },
        { response: "Un petit peu", score: 1 },
        { response: "Beaucoup", score: 2 },
        { response: "Enormement", score: 3 }
      ]
    },
    {
      question: "L’élève fait des crises de colère",
      answers: [
        { response: "Pas du tout", score: 0 },
        { response: "Un petit peu", score: 1 },
        { response: "Beaucoup", score: 2 },
        { response: "Enormement", score: 3 }
      ]
    },
    {
      question: "L’élève a une humeur qui change rapidement et de façon marquée",
      answers: [
        { response: "Pas du tout", score: 0 },
        { response: "Un petit peu", score: 1 },
        { response: "Beaucoup", score: 2 },
        { response: "Enormement", score: 3 }
      ]
    },
    {
      question: "L’élève est bagarreur",
      answers: [
        { response: "Pas du tout", score: 0 },
        { response: "Un petit peu", score: 1 },
        { response: "Beaucoup", score: 2 },
        { response: "Enormement", score: 3 }
      ]
    },
    {
      question: "L’élève est puéril, immature",
      answers: [
        { response: "Pas du tout", score: 0 },
        { response: "Un petit peu", score: 1 },
        { response: "Beaucoup", score: 2 },
        { response: "Enormement", score: 3 }
      ]
    },
    {
      question: "L’élève n’arrête pas de bouger, de gigoter",
      answers: [
        { response: "Pas du tout", score: 0 },
        { response: "Un petit peu", score: 1 },
        { response: "Beaucoup", score: 2 },
        { response: "Enormement", score: 3 }
      ]
    },
    {
      question: "L’élève est incapable de rester immobile",
      answers: [
        { response: "Pas du tout", score: 0 },
        { response: "Un petit peu", score: 1 },
        { response: "Beaucoup", score: 2 },
        { response: "Enormement", score: 3 }
      ]
    },
    {
      question: "L’élève a des demandes qui doivent être satisfaites immédiatement",
      answers: [
        { response: "Pas du tout", score: 0 },
        { response: "Un petit peu", score: 1 },
        { response: "Beaucoup", score: 2 },
        { response: "Enormement", score: 3 }
      ]
    },
    {    question: "L’élève perturbe les autres élèves",    answers: [      { label: "Pas du tout", score: 0 },      { label: "Un petit peu", score: 1 },      { label: "Beaucoup", score: 2 },      { label: "Enormément", score: 3 }    ]
  },
  {
    question: "L’élève est incapable de se tenir tranquille lors des activités et loisirs",
    answers: [
      { label: "Pas du tout", score: 0 },
      { label: "Un petit peu", score: 1 },
      { label: "Beaucoup", score: 2 },
      { label: "Enormément", score: 3 }
    ]
  },
  {
    question: "L’élève termine les phrases des autres et ne peut pas attendre son tour dans une conversation",
    answers: [
      { label: "Pas du tout", score: 0 },
      { label: "Un petit peu", score: 1 },
      { label: "Beaucoup", score: 2 },
      { label: "Enormément", score: 3 }
    ]
  },
  {
    question: "L’élève rencontre des difficultés en orthographe",
    answers: [
      { label: "Pas du tout", score: 0 },
      { label: "Un petit peu", score: 1 },
      { label: "Beaucoup", score: 2 },
      { label: "Enormément", score: 3 }
    ]
  },
  {
    question: "L’élève ne lit pas aussi bien que les élèves de sa classe",
    answers: [
      { label: "Pas du tout", score: 0 },
      { label: "Un petit peu", score: 1 },
      { label: "Beaucoup", score: 2 },
      { label: "Enormément", score: 3 }
    ]
  },
  {
    question: "Lors d’un devoir, l’élève ne parvient pas à prêter attention aux détails ou commet des fautes d’étourderie",
    answers: [
      { label: "Pas du tout", score: 0 },
      { label: "Un petit peu", score: 1 },
      { label: "Beaucoup", score: 2 },
      { label: "Enormément", score: 3 }
    ]
  },
  {
    question: "L’élève a du mal à organiser ses travaux ou ses activités",
    answers: [
      { label: "Pas du tout", score: 0 },
      { label: "Un petit peu", score: 1 },
      { label: "Beaucoup", score: 2 },
      { label: "Enormément", score: 3 }
    ]
  }


   ]
 }
]
const questionAll = [Dysorthographique,Dyslexie,TDA ]
let scoreTest = [{nom: "Dysorthographique", score : 0},{nom: "Dyslexie",score : 0},{nom:"TDA",score :0}]
let questionCount = 0;
const response = ["Oui","Non"];
const responseSecondaire = ["Pas du tout","Un petit peu","Beaucoup","Enormément"]
const reponseSaved = [];
const infoTest = document.querySelector("h1");
const inputContainer = document.querySelector(".inputContainer");
const confirmBtn = document.querySelector("#confirmBtn");
const resBtn = document.querySelector("#resBtn");
const labelInput = document.querySelectorAll(".labelInput");
const btnContainer =   document.querySelector(".btnContainer");
//boollean

let questionPrincipaleBool = false;
let questionsSecondaireBool = false;





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
  
  btnContainer.style.top = "30%";
  
  //creation des nouveaux labels et radio input
  infoTest.style.fontSize = "2rem";

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
  questionPrincipaleBool = true;
  
  nextQuestion();
  
}
function gameStart(){
  
 
   currentEleve = eleveInput.value;

 

  
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
  console.log(score);
  let maxScore = nbrQuestion*3;
  score = score/maxScore;
  score = score*100;
  return score;
}
function checkResponse(){ 
if(questionCount < questionAll.length){
if(mainCount < questionAll[questionCount].length){

if(count < questionAll[questionCount][mainCount].questionsSecondaire.length){
  console.log("yes")
if(questionPrincipaleBool == true){
  selectedValue = getRadioValue("radio");
  reponseSaved.push(selectedValue);
  if(selectedValue == "Oui"){
    questionPrincipaleBool = false;
    questionsSecondaireBool = true;
    console.log('yesyes')
    nextQuestion()
  }
  else{
    console.log("yes");
    mainCount++;
   nextQuestion();
  }
}
else if(questionsSecondaireBool == true){
  selectedValue = getRadioValue("radio");
  if(selectedValue == "Pas du tout"){
    score += questionAll[questionCount][mainCount].questionsSecondaire[count].answers[0].score;
    
  }
  else if(selectedValue == "Un petit peu"){
    score += questionAll[questionCount][mainCount].questionsSecondaire[count].answers[1].score;
  }
  else if(selectedValue == "Beaucoup"){
    score += questionAll[questionCount][mainCount].questionsSecondaire[count].answers[2].score;

  }else if(selectedValue == "Enormément"){
    score += questionAll[questionCount][mainCount].questionsSecondaire[count].answers[3].score;
  }
  nextQuestion();
}
}
else{
  questionsSecondaireBool = false;
  questionPrincipaleBool =true;
  count = 0;
  mainCount++;
  nextQuestion();
}
}
else{
  const inputRadio = document.querySelectorAll(".reponse");
  inputRadio.forEach((radio)=>{
    radio.remove();
  })//supp previous radio check
  console.log(score);
  let resultToPush = getRatio(score);
  resultToPush = Math.floor(resultToPush);
  resultat.push(resultToPush)
  console.log (resultat);
  console.log("hello");
  console.log(nbrQuestion);
  mainCount = 0;
  score = 0
  questionCount++;
  nbrQuestion =0;
  nextQuestion();
}
}
else{
  const inputRadio = document.querySelectorAll(".reponse");
  inputRadio.forEach((radio)=>{
    radio.remove();
  })//supp previous radio check
  endGame()
}
}
function createRadio(responseName){
  for(let i = 0 ; i < responseName.length; i++){
    let responseString = responseName[i];
   
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
}

function nextQuestion(){ 

  if(questionPrincipaleBool == true){
    if(mainCount > questionAll[questionCount].length){
      
      const inputRadio = document.querySelectorAll(".reponse");
      inputRadio.forEach((radio)=>{
        radio.remove();
      })//supp previous radio check
      checkResponse();
    }
    else{
    const inputRadio = document.querySelectorAll(".reponse");
    inputRadio.forEach((radio)=>{
      radio.remove();
    })//supp previous radio check
    createRadio(response)
  }
 if(questionAll[questionCount][mainCount].questionsPrincipale == " "){
  const inputRadio = document.querySelectorAll(".reponse");
  inputRadio.forEach((radio)=>{
    console.log('yes')
    radio.remove();

  })//supprimer tous les elements qui ont été créer precedemment
  const responseName = ["Oui"];
  for(let i = 0 ; i < responseName.length; i++){
    let responseString = responseName[i];
   
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
    checkInput.checked = true;
    checkLabel.appendChild(checkInput);
    inputContainer.appendChild(checkLabel);
  }
  const QuestionString = "Quelques questions pour affiner le test"
  infoTest.innerHTML = `${QuestionString}`;
  
 }
 else{
  infoTest.innerHTML = `${questionAll[questionCount][mainCount].questionsPrincipale}`;
 }
  
}else if(questionsSecondaireBool == true) {
  console.log(count);
  infoTest.innerHTML = `${questionAll[questionCount][mainCount].questionsSecondaire[count].question}`;
  const inputRadio = document.querySelectorAll(".reponse");
  inputRadio.forEach((radio)=>{
    radio.remove();
  })//supp previous radio check
  createRadio(responseSecondaire)
  
  count++;
  nbrQuestion++;
}
  
}

function previousQuestion(){
  const checkInput = document.querySelectorAll(".response");
  
  count--;
  infoTest.innerHTML = `${questions[count].question}`;
}

function endGame(){
  const inputRadio = document.querySelectorAll(".reponse");
  inputRadio.forEach((radio)=>{
   console.log('yes')
    radio.remove();
  })//supprimer tous les elements qui ont été créer precedemment
  inputContainer.style.height = "60%";
  previousBtn.remove();
  nextBtn.remove();
  //afficher le layout 
  
  resBtn.textContent = "Envoyer les résultats";
  btnContainer.style.position = "relative";
  btnContainer.style.top = "-10%"
  
  const sendRes = document.createElement("button");
  sendRes.setAttribute("class","submitBtn");
  sendRes.setAttribute("id","sendRes");
  sendRes.textContent = "Envoyez les résultats";
  btnContainer.appendChild(sendRes);
  btnContainer.style.height = "50%";

  infoTest.style.display = "flex";
  infoTest.style.flexDirection = "column"
  infoTest.style.rowGap = "25px";
  infoTest.textContent = " ";

  //afficher le score
  for(let i = 0 ; i< resultat.length ; i++){
    let testResultatDiv = document.createElement("div");
    testResultatDiv.textContent += scoreTest[i].nom + ": "; 
    infoTest.appendChild(testResultatDiv);
    let barContainer = document.createElement("div");
    barContainer.setAttribute("class","bar")
    testResultatDiv.appendChild(barContainer);
    let bar = document.createElement("div");
    bar.setAttribute("class","barpercent");
    let percentResult = document.createElement("div");
    percentResult.setAttribute("class","percent")
    percentResult.textContent += resultat[i] + "%";
    
    bar.appendChild(percentResult);
    let id = null;
    let width = 0;        
    clearInterval(id);
    id = setInterval(frame1 , 30);   
    console.log(resultat);     
    function frame1(){
         if(bar.style.width == resultat[i] + "%"){
           clearInterval(id);
         }
         else{
          width++;
          if(width < 20){
              bar.style.backgroundImage = "-webkit-linear-gradient(left,indigo,blue)";
          }
          else if (width >= 20 && width < 40 ){
              bar.style.backgroundImage = "-webkit-linear-gradient(left,indigo,blue, green)"
          }
          else if( width >=40 && width <60){
              bar.style.backgroundImage = "-webkit-linear-gradient(left,indigo,blue, green,yellow)"
          }
          else if(width >=60 && width < 80){
              bar.style.backgroundImage = "-webkit-linear-gradient(left,indigo,blue, green,yellow,orange)"
          }
          else if(width >= 80 && width<100){
              bar.style.backgroundImage = "-webkit-linear-gradient(left,indigo,blue, green,yellow,orange,red)"
          }
          }
         
          bar.style.width = width + "%";
     
         }
    barContainer.appendChild(bar);

  }

  
   


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
  document.querySelector("#eleve").value = " ";
}