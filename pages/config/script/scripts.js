const tokenCookieName = "accesToken";
const btnDeconnexion = document.getElementById("btn-deconnexion");
const roleCookieName = "role";

btnDeconnexion.addEventListener("click", deconnected);

function getRole(){
    return getCookie(roleCookieName);
}

function deconnected(){
    eraseCookie(tokenCookieName);
    eraseCookie(roleCookieName);
    window.location.reload();
}

function setToken(token){
    setCookie(tokenCookieName, token, 7);
}

function getToken(){
    return getCookie(tokenCookieName);
}

function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

function eraseCookie(name) {   
    document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

function isConnected(){
    const token = getToken();
    if(token == null || token == undefined){
        return false;
    }else{
        return true;
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const token = getToken(); // suppose que tu as une fonction pour récupérer le token
    const isConnected = !!token;

    document.querySelectorAll("[data-show]").forEach(el => {
        const shouldShow = el.getAttribute("data-show") === (isConnected ? "connected" : "disconnected");
        el.style.display = shouldShow ? "" : "none";
    });
});


/*
5 utilisateurs possible :
1- utilisateur déconnecté 
2- utilisateur connecté (client, vétiraire, employé ou admin)
    - vétérinaire
    - employé
    - admin
*/

function showAndHideElement(){
    const userConnected = isConnected();
    const role = getRole();

    let allElementToEdit = document.querySelectorAll('[data-show]');
    allElementToEdit.forEach(element =>{
        switch(element.dataset.show){
            case 'disconnected':
                if(userConnected){
                    element.classList.add("d-none");
                }
                break;
            case 'connected':
                if(!userConnected){
                    element.classList.add("d-none");
                }
                break;
            case 'employe':
                if(!userConnected || role != "employe"){
                    element.classList.add("d-none");
                }
                break;
            case 'admin':
                if(!userConnected || role != "admin"){
                    element.classList.add("d-none");
                }
                break;
        }
    })
}

document.addEventListener("DOMContentLoaded", () => {
    showAndHideElement();
});
