<?php
$host = "localhost"; 
$user = "root"; 
$password = ""; 
$dbname = "covoiturage"; 

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

$sql = "SELECT * FROM trajets ORDER BY date_depart ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '
        <div class="trip-card">
            <div class="d-flex justify-content-between align-items-center">
                <strong>' . date("d F Y", strtotime($row['date_depart'])) . '</strong>
                <strong>' . $row['ville_depart'] . ' - ' . $row['ville_arrivee'] . '</strong>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-2">
                <span>⏰ ' . $row['heure_depart'] . ' - ' . $row['heure_arrivee'] . '</span>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-2">
                <div>
                    <strong>🚗 ' . $row['conducteur'] . '</strong> ⭐ ' . $row['note'] . '
                </div>
                <span>' . $row['places_disponibles'] . ' places restantes</span>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <button class="btn credit-btn"> ' . $row['prix'] . ' Crédit</button>
            </div>
        </div>';
    }
} else {
    echo "<p>Aucun trajet disponible.</p>";
}

$conn->close();
?>
