<?php
session_start();
$isConnected = isset($_SESSION["email"]); // ou selon ton système de session
?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const isConnected = <?= $isConnected ? 'true' : 'false' ?>;

        document.querySelectorAll('[data-show]').forEach(el => {
            const shouldShow = el.getAttribute('data-show') === (isConnected ? 'connected' : 'disconnected');
            el.style.display = shouldShow ? '' : 'none';
        });
    });
</script>

<div class="map-circle">
    <img src="../images/map.jpg" alt="Carte GPS" class="map-image">
</div>



<div class="container mt-5">
    <div class="row">
        <!-- Première colonne -->
        <div class="col-md-4">
            <div class="card text-center shadow">
                <div class="card-body">
                    <img src="../images/location-4496459_1280.webp" alt="Ecoride" class="icon">
                    <h4 class="text-primary">ECORIDE</h4>
                    <ul class="text-left">
                        <li>Bienvenue sur EcoRide !</li>
                        <li>La plateforme de covoiturage écologique pour voyager économiquement tout en préservant la planète.</li>
                        <li>Rejoignez une communauté engagée et réduisez votre empreinte carbone.</li>
                        <li>Voyageons mieux, voyageons <span class="text-success">ensemble</span>.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Deuxième colonne -->
        <div class="col-md-4">
            <div class="card text-center shadow">
                <div class="card-body">
                    <img src="../images/man.webp" alt="Notre Start Up" class="icon">
                    <h4 class="text-primary">NOTRE START UP</h4>
                    <ul class="text-left">
                        <li>Nouvelle startup française, EcoRide vise à réduire l'impact environnemental des déplacements.</li>
                        <li>Portée par José, son directeur technique, l’entreprise développe une application web pour allier <span class="text-success">écologie</span> et <span class="text-success">praticité</span>.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Troisième colonne -->
        <div class="col-md-4">
            <div class="card text-center shadow">
                <div class="card-body">
                    <img src="../images/award-8207550_1280.webp" alt="Notre Ambition" class="icon">
                    <h4 class="text-primary">NOTRE AMBITION</h4>
                    <ul class="text-left">
                        <li>EcoRide est la <span class="text-success">référence</span> du covoiturage écoresponsable !</li>
                        <li>EcoRide aspire à devenir la plateforme <span class="text-success">incontournable</span> pour les voyageurs écolos et économiques.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <hr>
</div>

<div class="container">
    <h2>
        TROUVEZ VOTRE <stan class="text-secondary">COVOITURAGE</stan> !
    </h2>
    <h3> Vous cherchez un moyen de voyager de manière écologique et économique ? 
    Trouvez dès maintenant votre covoiturage idéal parmi les trajets disponibles et partagez votre voyage en toute simplicité !</h3>
    <div class="btn-center">
    <a class="btn btn-primary btn-trouver" href="/itineraire">Trouver un trajet </a>
</div>
</div>

