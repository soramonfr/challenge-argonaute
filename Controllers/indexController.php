<?php
spl_autoload_register(function ($class) {
    include 'models/' . $class . '.php';
});

$br = "<br>";

$database = new Database();
$crewManager = new Crew($database);

$crewCounter = $crewManager->countCrew();
$crewMembers = $crewManager->displayCrewMembers();

function genderIcon($gender)
{
    if ($gender === "Femme") {
        $genderIcon = "<i class=\"fas fa-venus\"></i>";
    } elseif ($gender === "Homme") {
        $genderIcon = "<i class=\"fas fa-mars\"></i>";
    }
    return $genderIcon;
}

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

var_dump(($crewCounter[0]));

// Traitement des données après envoi du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérification du nombre de personnes présentes dans l'équipage (On en veut 50) puis traitement
    if ($crewCounter[0] >= 50) {
        $status = "L'équipage est déjà au complet";
    } else {
        // Application du premier filtre de sécurité
        $lastname = isset($_POST["lastname"]) ? cleanData($_POST["lastname"]) : "";
        $firstname = isset($_POST["firstname"]) ? cleanData($_POST["firstname"]) : "";
        $description = isset($_POST["description"]) ? cleanData($_POST["description"]) : "";
        $gender = isset($_POST["gender"]) ? cleanData($_POST["gender"]) : "";

        // Application du second filtre de sécurité
        // Pour la saisie du nom
        if (preg_match($regexName, $lastname)) {
            $verifiedLastname = mb_strtoupper($lastname);
        } else {
            $arrayErrors['lastname'] = "Veuillez saisir un nom valide.";
        }
        // Pour la saisie du prénom
        if (preg_match($regexName, $firstname)) {
            $verifiedFirstname = ucfirst(strtolower($firstname));
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
                //  Mise à jour du compteur
                $crewCounter = $crewManager->countCrew();
            } else {
                $status = "❌ Ce membre a déjà été renseigné.";
            }
        } else {
            $status = "❌ Veuillez compléter tous les champs avant de poursuivre.";
        }
    }
}
