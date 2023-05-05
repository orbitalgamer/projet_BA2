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
    const id = document.querySelector('.boxID')
    const mdp = document.querySelector('.boxpassword')
    console.log(id.value)
    const idSplite = id.value.split(".");
    fetch("https://api.themistest.be/api/Connection/Connection.php",{
      method: "POST",
      headers: {'Content-Type':'application/json'},
      body: JSON.stringify({"Identifiant": id.value , "Mdp": mdp.value})
  
  }).then(response=>{return response.json()}).then(data=> {
      localStorage.setItem("Token", data.data.Token);
      if(data.message == "succes"){
        fetch("https://api.themistest.be/api/Enseignant/Affichage.php",{
          method:"POST",
          body:JSON.stringify({Token: localStorage.getItem("Token")})
        }).then(response => response.json()).then(data => {
          if(data.data[0].Admin == "1"){
            switcher.setAttribute("href", "../Admin_View/Admin_Screen.html")
          }
          else if( data.data[0].Admin == "0"){
            switcher.setAttribute("href","../Prof_View/prof_view.html");
          }
          else{
            return;
          }
        })
      }
      else{
        return;
      }
  })
    
  })

 
  