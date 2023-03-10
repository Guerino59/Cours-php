<?php 
session_start();
require "../ressources/service/_csrf.php";
/* 
    Une attaque connue possible sur un site web est l'attaque XSS (Cross-Site Scripting).
    Le principe de ce genre d'attaque, est d'insérer des scripts étranger à notre page.

    En développement, un des principes de base de la sécurité, est la phrase : 
    ! "Don't trust users"

    Pour se protéger des attaques XSS, on doit filtrer les entrées des utilisateurs.
    Cela on l'a déjà fait avec la fonction "htmlspecialchars()"
    D'autres sont utilisable comme "htmlentities()"
*/ 

/* 
    Dans le chapitre précédent, j'ai parlé de mot de passe hashé. 
    Ce terme obscure dont on entend peu parler au détriment de "chiffré" ou "crypté" est pourtant celui qui correspond le mieux.
        (crypté est un anglicisme, il correspond à chiffré)

    Un string chiffré peut être déchiffré. Plus ou moins difficilement selon la méthode utilisée.
    Un string hashé, ne peut pas revenir à la normal.

    Une messagerie sécurisé chiffrera les messages.
    Un site sécurisé, hashera les mots de passes.

    On a vu comment vérifier un mot de passe hashé dans le chapitre précédent.
    Mais pour hasher un mot de passe voici comment faire :
*/
$error = $password = "";
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['hash']))
{
    if(empty($_POST["password"]))
        $error = "Veuillez entrer un mot de passe";
    else
    {
        /* 
            Le mot de passe n'étant pas stocké en clair, ni affiché sur une page, 
            je n'ai pas besoin de l'assainir avec "htmlspecialchars()"
        */
        $password = trim($_POST["password"]);
        /* 
            "password_hash()" permet de hasher un mot de passe donné en premier argument.

            En second il prendra une constante prédéfini dans PHP, au choix entre :
                PASSWORD_DEFAULT
                PASSWORD_BCRYPT
                PASSWORD_ARGON2I
                PASSWORD_ARGON2ID
            
            Ce sont des constantes qui représente les différents algorythmes de hashage disponible dans PHP.

            PASSWORD_DEFAULT est un raccourci pour l'un des suivants défini par défaut par PHP.
            En PHP 8.1 "PASSWORD_DEFAULT" représente "PASSWORD_BCRYPT"

            Il est conseillé d'utiliser "DEFAULT" car il est automatiquement changé aux mises à jour de PHP si un meilleur algorythme est ajouté. 

            En troisième argument, on peut ajouter un tableau d'options pour modifier certains algorythme, mais pour cela référez vous à la documentation. 
            On pouvait par exemple avant changer le "cost" de BCRYPT mais maintenant la documentation conseille de ne pas le faire.
        */
        $password = password_hash($password, PASSWORD_DEFAULT);
        /* 
            Il nous reste à nous protéger des attaques CSRF et Brute force.
            (On parlera des injections SQL lorsque nous communiqueront avec la BDD)
        */
    }
    if(!isset($_POST["captcha"],$_SESSION["captchaStr"]) || $_POST["captcha"] != $_SESSION["captchaStr"])
    $error = "Captcha incorrecte !";
    /*
        On s'est protegé des bots via un captcha (privilegier un captcha develloper par des pro)
        Mais on va pas placer de captcha sur tous nos formulaires
        Gardons celui-ci pour les formulaires des utilsateurs non inscrit

        Il nous reste une faille a voir, les attazques CSRF
    */
    if(!isCSRFValid())
    $error  = "La methode utilisée n'est pas permise";
}
$title = "Sécurité";
require "../ressources/template/_header.php";
?>
<form action="" method="post">
    <input type="password" name="password" placeholder="Mot de passe à hasher" required>
    //captcha
    <div>
        <label for="captcha">VEUILLEZ RECOPIER LE TEXTE CI DESSOUS</label>
        <br>
        <img src="../ressources/service/_captcha.php" alt="captcha">
        <br>
        <input type="text" name="captcha" id="captcha" pattern="[A-Z0-9]{6}">
    </div>
    // CSRF
    <?php setCSRF(5); ?>
    <input type="submit" name="hash" value="hasher">
    <br>
    <span class="error"><?php echo $error??"" ?></span>
</form>
<?php if(empty($error) && !empty($password)): ?>
    <!-- 
        On remarquera que si on hashe deux fois le même mot de passe, 
        On obtiendra des résultats différents.
    -->
    <div>
        Votre mot de passe hashé est :
        <?php echo $password ?>
    </div>
<?php 
endif;
require "../ressources/template/_footer.php";
?>