<?php
spl_autoload_register(function ($class) {
    include 'models/' . $class . '.php';
});

$br = "<br>";

$database = new Database();
$crewManager = new Crew($database);

$crewCounter = $crewManager->countCrew();
$crewMembers = $crewManager->displayCrewMembers(); 
var_dump($crewMembers);

// Mise en place de la sécurité

// Initialisation du tableau d'erreurs
$arrayErrors = [];

// Génération des regex
// Pour la saisie d'un nom ou prénom
$regexName = "/^[a-zA-Zéèäëïçõãê -]+$/";

// Pour la saisie d'un ou plusieurs adjectifs
$regexDescription = "/^[a-zA-Zéèäëïçõãê -,]+$/";

// Filtrage des données potentiellement dangereuses
// htmlspecialchars() va permettre d’échapper certains caractères spéciaux comme les chevrons « < » et « > » en les transformant en entités HTML.
// trim() qui va supprimer les espaces inutiles et stripslashes() qui va supprimer les antislashes.
function cleanData($var)
{
    $var = trim($var);
    $var = stripslashes($var);
    $var = htmlspecialchars($var);
    return $var;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Application du premier filtre de sécurité
    $lastname = isset($_POST["lastname"]) ? cleanData($_POST["lastname"]) : "";
    $firstname = isset($_POST["firstname"]) ? cleanData($_POST["firstname"]) : "";
    $description = isset($_POST["description"]) ? cleanData($_POST["description"]) : "";
    $gender = isset($_POST["gender"]) ? cleanData($_POST["gender"]) : "";

    // Application du second filtre de sécurité
    // Pour la saisie du nom
    if (preg_match($regexName, $lastname)) {
        $verifiedLastname = $lastname;
    } else {
        $arrayErrors['lastname'] = "Veuillez saisir un nom valide.";
    }
    // Pour la saisie du prénom
    if (preg_match($regexName, $firstname)) {
        $verifiedFirstname = $firstname;
    } else {
        $arrayErrors['firstname'] = "Veuillez saisir un prénom valide.";
    }
    // Pour la saisie des caractéristiques 
    if (preg_match($regexDescription, $description)) {
        $verifiedDescription = $description;
    } else {
        $arrayErrors['description'] = "Veuillez saisir une description valide.";
    }
    // Pour la sélection du genre
    $validGender = array("Femme", "Homme");
    if (in_array($gender, $validGender)) {
        $verifiedGender = $gender;
    } else {
        $arrayErrors['gender'] = "Veuillez saisir un genre.";
    }

    // Stockage des données saisies
    if (empty($arrayErrors)) {

        $arrayParameters = [
            "lastname" => $verifiedLastname,
            "firstname" => $verifiedFirstname,
            "gender" => $verifiedGender,
            "description" => $verifiedDescription
        ];

        $crewMember = $crewManager->createCrewMember($arrayParameters);
        if ($crewMember) {
            $status = "✅ La saisie de l'argonaute a été traitée avec succès.";
            $crewCounter = $crewManager->countCrew();
        } else {
            $status = "❌ Des erreurs sont survenues pendant le traitement de la demande, veuillez recommencer.";
        }
    } else {
        $status = "❌ Veuillez compléter tous les champs avant de poursuivre.";
    }
}
