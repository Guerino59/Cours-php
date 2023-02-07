<?php

require "../ressources/service/_shouldBeLogged.php";
shouldBeLogged(true, "./exercice/connexion.php");

// Si on a pas d'Id ou que ce n'est pas celui de l'utilisateur connecté
// if (empty($_GET['id']) || $_SESSION["idUSer"] != $_GET["id"]) {
//     header("Location: ./02-read.php");
//     exit;
// }
require "../ressources/service/_pdo.php";

// On supprime l'utilisateur
$pdo = connexionPDO();
$sql = $pdo->prepare("DELETE * FROM users WHERE idUser = ?");
$sql->execute([(int)$_GET["id"]]);

// On deconnecte l'utilisateur
unset($_SESSION);
session_destroy();
setcookie("PHPSESSID", "", time() - 3600);

// On le redirige apres quelque secondes

header("refresh: 5; url = /");


$title = "CRUD - Delete";
require "../ressources/template/_header.php";

echo $sql->rowCount(), " ligne(s) effacé(s)";
?>
<p>
    Vous avez bien supprimé votre compte. <br>
    Vous allez être redirigé d'ici peu
</p>




<?php
require "../ressources/template/_footer.php";
?>