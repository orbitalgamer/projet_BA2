'use strict';
const ID = {"Identifiant": "nom.prenom", "Mdp":"test"}

  const switcher = document.querySelector(".boxconnexion");
  switcher.addEventListener('mouseover',function(){
      
    document.getElementById('notover').id  = 'over';
    
  } );

switcher.addEventListener('mouseout',function(){

    document.getElementById('over').id  = 'notover';
    
  } );
  switcher.addEventListener('click',()=>{
    const id = document.querySelector('.boxID').value
    const mdp = document.querySelector('.boxpassword').value
    ID.Identifiant = test
    ID.Mdp = test2
    console.log(ID)
  })
  fetch("https://api.themistest.be/api/Connection/Connection.php",{
    method: "POST",
    headers: {'Content-Type':'application/json'},
    body: JSON.stringify(ID)
    //JSON.parse
  }
  
  ).then(response=>{return response.json()}).then(data=>{fetch("https://api.themistest.be/api/Enseignant/Affichage.php?Id=All",{
    method:"POST",
    body:JSON.stringify({Token:data.data.Token})
  }).then(response=>response.json()).then(data=>console.log(data))})
 
  