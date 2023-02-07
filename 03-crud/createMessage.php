<?php
require "../ressources/service/_csrf.php";
require "../ressources/service/_shouldBeLogged.php";
require "../ressources/service/_pdo.php";
shouldBeLogged(true, "./exercice/connexion.php");

$title = "Ajoute un message";
require "../ressources/template/_header.php";

if ($_SESSION["idUser"] != $_GET["id"]) {
    header("Location: ./02-read.php");
    exit;
}
$pdo = connexionPDO();
$sql = $pdo->query("SELECT * FROM categorie");
$categ = $sql->fetchAll();
var_dump($categ);
$message = $select = "";
$error = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    if (empty($_POST["message"]))
        $error["message"] = "Attention, ton message est vide !";
    else {
        $message = cleanData($_POST["message"]);
        if (strlen($message) < 10)
            $error["message"] = "Attention, ton message doit contenir plus de 10 caracteres!";
    }
    if (empty($_POST["categorie"]))
        $error["categorie"] = "Veuillez choisir une categorie pour votre message !";
    else
        $select = cleanData($_POST["categorie"]);
    if (empty($error)) {
        $sql = $pdo->prepare("INSERT INTO messages(idUser, message, idCat) VALUES(?, ?, ?)");
        $sql->execute([$_SESSION["idUser"], $message, $select]);
        $_SESSION["flash"] = "Votre message à bien été ajouté";
        header("Location: ./02-read.php");
        exit;
    }
}





?>
<form action="" method="post">
    <label for="mess">Nouveau message :</label>
    <br>
    <textarea name="message" id="message" cols="30" rows="10"></textarea>
    <br>
    <span class="error"><?php echo $error["message"] ?? ""; ?></span>
    <br>
    <select name="categorie" id="categorie">
        <option value="">Choisir une categorie pour votre message</option>
        <?php foreach ($categ as $cat) : ?>
            <option value="<?php echo $cat["idCat"] ?>"><?php echo $cat["idCat"] . " - " . $cat["nom"] ?></option>
        <?php endforeach; ?>
    </select>
    <br>
    <span class="error"><?php echo $error["categorie"] ?? ""; ?></span>
    <br>
    <input type="submit" value="Ajouter" name="add">
</form>
<?php
require "../ressources/template/_footer.php";
?>