<?php 

require_once(dirname(__FILE__) . "/../database.php");

function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

$prenom = sanitizeInput($_POST["prenom"]);
$nom = sanitizeInput($_POST["nom"]);
$pseudo = sanitizeInput($_POST["pseudo"]);
$telephone = sanitizeInput($_POST["telephone"]);
$dateNaissance = sanitizeInput($_POST["dateNaissance"]);
$email = filter_var(sanitizeInput($_POST["mail"]), FILTER_VALIDATE_EMAIL);

$req = $dbh->prepare("SELECT * FROM user WHERE email = :email");
$req->bindParam(":email", $email);
$req->execute();
$result = $req->fetch(PDO::FETCH_ASSOC);

if ($result) {
    header("Location: /signup?message=exists");
    exit();
}

if (!$result) {
    // Hash du mot de passe de façon sécurisée
    $passwordTohash = $_POST["mdp"] . $config["SECRET_KEY"];  // Ajouter un sel au mot de passe
    $hashedPassword = md5($passwordTohash);  // Hacher le mot de passe
    $role = $config["ROLE"][0]; 
    $message = "compte créé avec succès";

    // Gestion de la photo
    $photoPath = null;
    if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES["photo"]["tmp_name"];
        $fileName = basename($_FILES["photo"]["name"]);
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (in_array($fileExtension, $allowedExtensions)) {
            // Crée un nom de fichier unique
            $newFileName = uniqid("user_") . '.' . $fileExtension;
            $uploadFileDir = dirname(__FILE__) . "/../../uploads/";
            $destPath = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $photoPath = "/pages/uploads/" . $newFileName; // Chemin à stocker en BDD
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

        header("Location: /");
        exit();
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>
