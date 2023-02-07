<?php

require "../ressources/service/_shouldBeLogged.php";
shouldBeLogged(true, "./exercice/connexion.php");

// Si on a pas d'Id ou que ce n'est pas celui de l'utilisateur connecté
// if (empty($_GET['id']) || $_SESSION["idUSer"] != $_GET["id"]) {
//     header("Location: ./02-read.php");
//     exit;
// }
require "../ressources/service/_pdo.php";
$pdo = connexionPDO();
$sql = $pdo->prepare("SELECT * FROM messages WHERE idMessage = ?");
$sql->execute([(int)$_GET["id"]]);
$delMessage = $sql->fetch();

if (empty($_GET["id"]) || $_SESSION["idUser"] != $delMessage["idUser"]) {
    header("Location: ./02-read.php");
    exit;
} else {
    // On supprime le message
    $sql = $pdo->prepare("DELETE FROM messages WHERE idMessage = ?");
    $sql->execute([(int)$delMessage["idMessage"]]);
    header("refresh: 5; url = ../03-crud/02-read.php");


    $title = "CRUD - Delete";
    require "../ressources/template/_header.php";

    echo $sql->rowCount(), " ligne(s) effacé(s)";
}

?>
<p>
    Vous avez bien supprimé votre message. <br>
    Vous allez être redirigé d'ici peu
</p>




<?php
require "../ressources/template/_footer.php";
?>