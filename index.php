<?php
require "Controllers/indexController.php";
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/a0b1e9dec7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/style.css">
    <title>Les Argonautes</title>
</head>

<body>
    <!-- Header section -->
    <header>
        <h1>
            <img src="https://www.wildcodeschool.com/assets/logo_main-e4f3f744c8e717f1b7df3858dce55a86c63d4766d5d9a7f454250145f097c2fe.png" alt="Wild Code School logo" />
            Les Argonautes
        </h1>
    </header>
    <!-- Main section -->
    <main>
        <!-- New member form -->
        <h2>Ajouter un(e) Argonaute</h2>
        <form class="new-member-form" action="index.php" method="post">
            <p class="text-info"><?= isset($status) ? $status : "" ?></p>
            <fieldset class="fieldset">
                <label for="firstname">🔰 Prénom : <span class="error-notification"><?= isset($arrayErrors['firstname']) ? $arrayErrors['firstname'] : "" ?></span></label>
                <input id="firstname" name="firstname" type="text" placeholder="Willy" /><br>

                <label for="lastname">🔰 Fils ou Fille de : <span class="error-notification"><?= isset($arrayErrors['lastname']) ? $arrayErrors['lastname'] : "" ?></span></label>
                <input id="lastname" name="lastname" type="text" placeholder="Wonka" /><br>

                <label for="description">🔰 Caracteristique(s) : <span class="error-notification"><?= isset($arrayErrors['description']) ? $arrayErrors['description'] : "" ?></span></label>
                <input id="description" name="description" type="text" placeholder="Gourmand, espiègle" /><br>

                <label for="gender">🔰 Genre : <span class="error-notification"><?= isset($arrayErrors['gender']) ? $arrayErrors['gender'] : "" ?></span></label>
                <select name="gender" id="gender-select">
                    <option value="">--Sélection du genre--</option>
                    <option value="Femme">Femme</option>
                    <option value="Homme">Homme</option>
                </select><br>
            </fieldset>
            <button type="submit">Envoyer</button>
        </form>

        <!-- Member list -->
        <h2>Membres de l'équipage (<?= $crewCounter[0] ?>/50)</h2>
        <section class="member-list">
            <?php
            if (!$crewMembers) {
                echo "⛔ Il y a eu un problème lors de la récupération des données.";
            } else {
                foreach ($crewMembers as $crewMember) {
                    echo "<div class=\"member-item\">" . genderIcon($crewMember["gender"]) . " " . $crewMember["firstname"]
                        . " (" . $crewMember["description"] . ")" . "</div>" . $br;
                }
            }
            ?>
        </section>
    </main>
    <!-- Footer section -->
    <footer>
        <p>Réalisé par Jason en Anthestérion de l'an 515 avant JC</p>
    </footer>
</body>

</html>