'use strict';
const ID = {"Identifiant": "nom.prenom", "Mdp":"test"}

  const switcher = document.querySelector(".boxconnexion");
  switcher.addEventListener('mouseover',function(){
      
    switcher.classList.add('over');
    
  } );

switcher.addEventListener('mouseout',function(){

  switcher.classList.remove('over');
    
  } );
  switcher.addEventListener('mousedown',function(){

    switcher.classList.add('clicked');
      
    } );
    switcher.addEventListener('mouseup',function(){

      switcher.classList.remove('clicked');
        
      } );

      switcher.addEventListener('touchstart', function() {
        switcher.classList.add('clicked');
      });
      
      switcher.addEventListener('touchend', function() {
        switcher.classList.remove('clicked');
      });
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
                //switcher.setAttribute("href", "../Admin_View/Admin_Screen.html")
                window.location.assign("../Admin_View/Admin_Screen.html"); //pour chargée nouvelle page
              }
              else if( data.data[0].Admin == "0"){
                /* switcher.setAttribute("href","../Prof_View/prof_view.html"); */
                window.location.assign("../Prof_View/prof_view.html"); //pour chargée nouvelle page
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
    
     
      
     
      