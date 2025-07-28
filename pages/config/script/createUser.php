<?php 
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once(dirname(__FILE__) . "/../database.php");
file_put_contents("log.txt", "Reçu : " . print_r($_POST, true), FILE_APPEND);
file_put_contents("log.txt", "Fichiers : " . print_r($_FILES, true), FILE_APPEND);

function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// 🔁 Utiliser $_POST au lieu de php://input
$prenom = sanitizeInput($_POST["prenom"]);
$nom = sanitizeInput($_POST["nom"]);
$pseudo = sanitizeInput($_POST["pseudo"]);
$telephone = sanitizeInput($_POST["telephone"]);
$dateNaissance = sanitizeInput($_POST["dateNaissance"]);
$email = filter_var(sanitizeInput($_POST["mail"]), FILTER_VALIDATE_EMAIL);
$password = $_POST["mdp"];

if (!$email) {
    echo json_encode(["success" => false, "error" => "Email invalide"]);
    exit;
}

// Vérifie si l'utilisateur existe déjà
$req = $dbh->prepare("SELECT * FROM user WHERE email = :email");
$req->bindParam(":email", $email);
$req->execute();
$result = $req->fetch(PDO::FETCH_ASSOC);

if ($result) {
    echo json_encode(["success" => false, "error" => "Email déjà utilisé"]);
    exit;
}

// Hash du mot de passe
$hashedPassword = password_hash($password . $config["SECRET_KEY"], PASSWORD_DEFAULT);
$role = $config["ROLE"][0];
$photoPath = null;

// 📸 Gestion de la photo
if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES["photo"]["tmp_name"];
    $fileName = basename($_FILES["photo"]["name"]);
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (in_array($fileExtension, $allowedExtensions)) {
        $newFileName = uniqid("user_") . '.' . $fileExtension;
        $uploadFileDir = dirname(__FILE__) . "/../../uploads/";
        $destPath = $uploadFileDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $photoPath = "/pages/uploads/" . $newFileName;
        }
    }
}

try {
    $req = $dbh->prepare("INSERT INTO user (prenom, nom, pseudo, email, mdp, telephone, dateNaissance, role, photo)
                          VALUES (:prenom, :nom, :pseudo, :email, :password, :telephone, :dateNaissance, :role, :photo)");
    $req->bindParam(":prenom", $prenom);
    $req->bindParam(":nom", $nom);
    $req->bindParam(":pseudo", $pseudo);
    $req->bindParam(":email", $email);
    $req->bindParam(":password", $hashedPassword);
    $req->bindParam(":telephone", $telephone);
    $req->bindParam(":dateNaissance", $dateNaissance);
    $req->bindParam(":role", $role);
    $req->bindParam(":photo", $photoPath);
    $req->execute();

    echo json_encode(["success" => true, "message" => "Compte créé avec succès"]);
    exit;
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => "Erreur SQL : " . $e->getMessage()]);
    exit;
}

?>
