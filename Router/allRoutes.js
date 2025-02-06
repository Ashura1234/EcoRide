import Route from "./route.js";

//Définir ici vos routes
export const allRoutes = [
    new Route("/", "Accueil", "/pages/accueil.html"),
    new Route("404", "Page introuvable", "/pages/404.html"),

];

//Le titre s'affiche comme ceci : Route.titre - websitename
export const websiteName = "Ecoride";