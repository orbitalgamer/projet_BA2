import { 
    
    menuIcon,
    menuIcon768px,
   
 }
 from "./button.js";
import {
 
    frameIconMenu,
    unframeIconMenu,
    showAndHideSideMenu,
    showAndHideSideMenu768px,
    
    frameIconMenu768px,
    unframeIconMenu768px,
   
   
    } 
    from "./fonction.js";

export const menuIconEvents = [
    menuIcon.addEventListener("mouseenter",frameIconMenu),
    menuIcon.addEventListener("mouseleave",unframeIconMenu),
    menuIcon.addEventListener("click",showAndHideSideMenu),
]
export const menuIconEvents768px = [
    menuIcon768px.addEventListener("click",showAndHideSideMenu768px),
    menuIcon768px.addEventListener("mouseenter",frameIconMenu768px),
    menuIcon768px.addEventListener("mouseleave",unframeIconMenu768px),

]

