import { 
    searchBarEvents,
    menuIconEvents,
    menuIconEvents768px,
    searchBarEvents768px,
    apiEvent
} 
from "./event.js";


searchBarEvents;
menuIconEvents;

apiEvent;

menuIconEvents768px;
searchBarEvents768px;




fetch("https://api.themistest.be/api/Groupe/Affichage.php?Id=All",{
    method:"POST",
    body :JSON.stringify({Token : localStorage.getItem("Token"),"IdClasse":"All"})
  }).then(response => response.json()).then(data => {console.log(data)})


