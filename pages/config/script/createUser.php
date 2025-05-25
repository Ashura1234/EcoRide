<?php 

require_once(dirname(__FILE__) . "/../database.php");


function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Récupération et sécurisation des champs
$prenom = sanitizeInput($_POST["prenom"]);
$nom = sanitizeInput($_POST["nom"]);
$pseudo = sanitizeInput($_POST["pseudo"]);
$telephone = sanitizeInput($_POST["telephone"]);
$dateNaissance = sanitizeInput($_POST["dateNaissance"]);
$email = filter_var(sanitizeInput($_POST["mail"]), FILTER_VALIDATE_EMAIL);



// Vérifie si l'utilisateur existe déjà
$req = $dbh->prepare("SELECT * FROM user WHERE email = :email");
$req->bindParam(":email", $email);
$req->execute();
$result = $req->fetch(PDO::FETCH_ASSOC);

if ($result) {
    header("Location: /signup?message=exists");
    exit();
}


if (!$result) {
// Hash du mot de passe
$passwordTohash = $_POST["mdp"] . $config["SECRET_KEY"]; 
$hashedPassword = md5($passwordTohash);
$role = $config["ROLE"][0]; // rôle par défaut
$message = "compte créé avec succès";
try {
    $req = $dbh->prepare("INSERT INTO user (prenom, nom, pseudo, email, mdp, telephone, dateNaissance, role) 
                          VALUES (:prenom, :nom, :pseudo, :email, :password, :telephone, :dateNaissance, :role)");
    $req->bindParam(":prenom", $prenom);
    $req->bindParam(":nom", $nom);
    $req->bindParam(":pseudo", $pseudo);
    $req->bindParam(":email", $email);
    $req->bindParam(":password", $hashedPassword);
    $req->bindParam(":telephone", $telephone);
    $req->bindParam(":dateNaissance", $dateNaissance);
    $req->bindParam(":role", $role);
    $req->execute();

    header("Location: /signin?message=$message&type=success");
    exit();
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
var_dump($_POST);
var_dump($_FILES);
exit;
}
?>
