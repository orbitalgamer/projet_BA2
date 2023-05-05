import { 
    searchBtn,  
    menuIcon,
    menuIcon768px,
    searchBtn768px,
 }
 from "./button.js";
import {
    showAndHideSearchBar,
    frameIconMenu,
    unframeIconMenu,
    showAndHideSideMenu,
    showAndHideSideMenu768px,
    showAndHideSearchBar768px,
    frameIconMenu768px,
    unframeIconMenu768px,
    getToken,
   
    } 
    from "./fonction.js";

export const searchBarEvents = searchBtn.addEventListener("click",showAndHideSearchBar)
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
export const searchBarEvents768px = searchBtn768px.addEventListener("click",showAndHideSearchBar768px);
export const apiEvent = [getToken()]