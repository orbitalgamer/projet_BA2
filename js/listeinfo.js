    'use strict';

    const switchers = document.querySelectorAll(".trouble");
    switchers.forEach(function(switcher){
    switcher.addEventListener('mouseover',function(){
        
    switcher.className = "trouble over";
    } );

    switcher.addEventListener('mouseout',function(){

        switcher.className = "trouble notover";
    } )

})


   