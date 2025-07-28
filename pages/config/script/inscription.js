//je veux implémenter le js de ma page, je vais vérifier le champ requis
const inputPrenom = document.getElementById("prenom");
const inputNom = document.getElementById("nom");
const inputPseudo = document.getElementById("pseudo");
const inputMail = document.getElementById("mail");
const inputMdp = document.getElementById("password");
const inputValideMdp = document.getElementById("passwordConfirm");
const inputNaissance = document.getElementById("yearsBorn");
const inputTel = document.getElementById("phoneNumber");
const inputPfp = document.getElementById("photo");
const btnInscription = document.getElementById("btn-inscription");
const form = document.getElementById("inscription-form");

inputPrenom.addEventListener("keyup", validateForm);
inputNom.addEventListener("keyup", validateForm);
inputPseudo.addEventListener("keyup", validateForm);
inputMail.addEventListener("keyup", validateForm);
inputNaissance.addEventListener("keyup", validateForm);
inputTel.addEventListener("keyup", validateForm);
inputMdp.addEventListener("keyup", validateForm);
inputPfp.addEventListener("change", validateForm);
inputValideMdp.addEventListener("keyup", validateForm);

function validateForm(){
    const prenomOk = ValidateRequired(inputPrenom);
    const nomOk = ValidateRequired(inputNom);
    const pseudoOK = ValidateRequired(inputPseudo);
    const mailOk = mailValid(inputMail);
    const mdpOk = mdpValid(inputMdp);
    const telOK = telValid(inputTel);
    const photoOK = ValidateRequired(inputPfp);
    const naissanceOK = dateValid(inputNaissance);
    const mdpValide = mdpvalided(inputMdp, inputValideMdp);


    if(prenomOk && nomOk && pseudoOK && mailOk && mdpOk && mdpValide && naissanceOK && telOK && photoOK) {
    btnInscription.disabled = false;
} else {
    btnInscription.disabled = true;
}
}

function mdpvalided(inputMdp, inputValideMdp){
    if(inputMdp.value == inputValideMdp.value){
        inputValideMdp.classList.add("is-valid");
        inputValideMdp.classList.remove("is-invalid");
        return true;
    }else{
        inputValideMdp.classList.add("is-invalid");
        inputValideMdp.classList.remove("is-valid");
        return false;
    }
}

function mdpValid(input){
    //définir une expression régulière --> regex
    const mdpRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,}$/;
    const userMdp = input.value;
    if(userMdp.match(mdpRegex)) {
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    } 
    else{
        input.classList.remove("is-valid");
        input.classList.add("is-invalid");
        return false;
    }
}

function mailValid(input){
    //définir une expression régulière --> regex
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const userMail = input.value;
    if(userMail.match(emailRegex)) {
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    } 
    else{
        input.classList.remove("is-valid");
        input.classList.add("is-invalid");
        return false;
    }
}

function ValidateRequired(input) {
    if(input.value != ''){
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    } 
    else{
        input.classList.remove("is-valid");
        input.classList.add("is-invalid");
        return false;
    }
}

function telValid(input) {
    const phoneRegex = /^(?:(?:\+33|0)[1-9])(?:\d{2}){4}$/;
    const userPhone = input.value.replace(/\s+/g, "");

    if (userPhone.match(phoneRegex)) {
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    } else {
        input.classList.remove("is-valid");
        input.classList.add("is-invalid");
        return false;
    }
}

function dateValid(input) {
    const dateStr = input.value;
    if (!dateStr) {
        input.classList.remove("is-valid");
        input.classList.add("is-invalid");
        return false;
    }

    const birthDate = new Date(dateStr);
    const today = new Date();

    const age = today.getFullYear() - birthDate.getFullYear();
    const monthDiff = today.getMonth() - birthDate.getMonth();
    const dayDiff = today.getDate() - birthDate.getDate();

    const isOldEnough = (
        age > 13 ||
        (age === 13 && (monthDiff > 0 || (monthDiff === 0 && dayDiff >= 0)))
    );

    if (isOldEnough) {
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    } else {
        input.classList.remove("is-valid");
        input.classList.add("is-invalid");
        return false;
    }
}

btnInscription.addEventListener("click", async (e) => {
    e.preventDefault();

    const form = document.querySelector("#inscription-form");
    const formData = new FormData(form);

    // 👇 Ajoute ça ici pour voir si les données sont bien captées
    for (let [key, value] of formData.entries()) {
        console.log(`${key}:`, value);
    }

    try {
        const response = await fetch("/pages/config/script/createUser.php", {
            method: "POST",
            body: formData
        });

        const contentType = response.headers.get("Content-Type");

        if (!contentType || !contentType.includes("application/json")) {
            const text = await response.text();
            console.error("Réponse non-JSON :", text);
            alert("❌ Erreur serveur : réponse non-JSON");
            return;
        }

        const result = await response.json();

        if (result.success) {
            alert("✅ " + result.message);
            window.location.href = "/connexion";
        } else {
            alert("❌ " + result.error);
        }
    } catch (error) {
        alert("❌ Erreur lors de l'inscription.");
    }
});
