<?php
session_start();
require "../ressources/service/_shouldBeLogged.php";
shouldBeLogged(true, "./exercice/connexion.php");


// if(empty($_GET["id"]))
//     header("Location: ./02-read.php");
//     exit;

require "../ressources/service/_pdo.php";
$pdo = connexionPDO();
$sql = $pdo->prepare("SELECT * FROM messages WHERE idUser = :getuser ");
$sql->execute(["getuser" => $_GET["id"]]);

$usersMessage = $sql->fetchAll();
$title = "Read Message";

require "../ressources/template/_header.php";

$sql = $pdo->prepare("SELECT * FROM users WHERE idUser = :getuser");
$sql->execute(["getuser" => $_GET["id"]]);
$usersName = $sql->fetch();
?>
<?php if (!$usersMessage) : ?>
    <p>L'utilisateur n'a publié aucun message.</p>
<?php else :  ?>
    <h1>Message de <?php echo $usersName["username"] ?></h1>
    <?php foreach ($usersMessage as $message) :  ?>
        <p><?php echo $message["message"] ?></p>
        <?php if ($_SESSION["idUser"] == $_GET["id"]) : ?>
            <a href="../03-crud/modifMessage.php?id=<?= $message["idMessage"] ?>">Modifier</a>
            <a href="../03-crud/deleteMessage.php?id=<?= $message["idMessage"] ?>">Supprimer</a>
        <?php endif; ?>
    <?php endforeach; ?>

<?php endif; ?>




<?php
require "../ressources/template/_footer.php";
?>