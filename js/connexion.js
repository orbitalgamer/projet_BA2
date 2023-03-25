'use strict';


  const switcher = document.querySelector(".boxconnexion");
  switcher.addEventListener('mouseover',function(){
      
    document.getElementById('notover').id  = 'over';
    
  } );

switcher.addEventListener('mouseout',function(){

    document.getElementById('over').id  = 'notover';
    
  } );