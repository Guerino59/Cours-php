<?php

require "../ressources/service/_shouldBeLogged.php";
shouldBeLogged(true, "./exercice/connexion.php");
require "../ressources/service/_csrf.php";
require "../ressources/service/_pdo.php";
$pdo = connexionPDO();
$sql = $pdo->prepare("SELECT * FROM messages WHERE idMessage=?");
$sql->execute([(int)$_GET["id"]]);
$message = $sql->fetch();
$modif = "";
$error = [];
if (empty($_GET["id"]) || $_SESSION["idUser"] != $message["idUser"]) {
    header("Location: ./02-read.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['modifMessage'])) {
    if (empty($_POST["modif"])) {
        $modif = $message["message"];
        $_SESSION["flash"] = "Votre Message est identique au precedent ";
        // Je redirige mon utilisateur
        header("Location: ./02-read.php");
        exit;
    } else {
        $modif = cleanData($_POST["modif"]);
    }
    $sql = $pdo->prepare("UPDATE messages SET message = :mess WHERE idMessage = :idMess");
    $sql->execute([
        "mess" => $modif,
        "idMess" => (int)$message["idMessage"]
    ]);

    $_SESSION["flash"] = "Votre Message a bien été édité.";
    // Je redirige mon utilisateur
    header("Location: ./02-read.php");
    exit;
}


$title = "Modifier message";
require "../ressources/template/_header.php";
?>
<form action="" method="post">
    <textarea name="modif" id="modif" cols="30" rows="10"><?php echo $message['message'] ?></textarea>
    <input type="submit" value="Modifier le message" name="modifMessage">
</form>

<?php
$title = "Modifier message";
require "../ressources/template/_footer.php";
?>