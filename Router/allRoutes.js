import Route from "./route.js";

//Définir ici vos routes
export const allRoutes = [
    new Route("/", "Accueil", "/pages/accueil.php"),
    new Route("404", "Page introuvable", "/pages/404.html"),
    new Route("/connexion", "connexion", "/pages/functions/connexion.html", ["disconnected"], "/pages/config/script/connexion.js"),
    new Route("/inscription", "inscription", "/pages/functions/inscription.html",["disconnected"], "/pages/config/script/inscription.js"),
    new Route("/deconnexion", "déconnexion", "/pages/functions/deconnexion.html"),
    new Route("/itineraire", "itinéraire", "/pages/services/itineraire.html"),
    new Route ("/reservations", "mes réservations", "/pages/services/reservations.html"),
    new Route ("/contact", "Nous contacter", "/pages/functions/contact.html"),
    new Route ("/creer", "créer un trajet", "/pages/services/creationTrajet.html"),
    new Route ("/mesTrajets", "mes Trajets", "/pages/services/mesTrajets.html"),
    new Route ("/profil", "profil", "/pages/services/profil.html"),
    new Route("/createUser", "/pages/config/script/createUser.php"),
];

//Le titre s'affiche comme ceci : Route.titre - websitename
export const websiteName = "Ecoride";