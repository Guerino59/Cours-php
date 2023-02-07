<?php
    session_start();
    require "../ressources/service/_mailer.php";
    $email = $subject = $body = $envoi = "";
    $error = [];
    if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['contact']))
    {
        if(empty($_POST["email"]))
            $error["email"] = "Veuillez entrer un email";
        else
        {
            $email = cleanData($_POST[["email"]]);
            /*
                La fonction filter_var permet de filter une variable
                Elle prend la variable en premiere argument et en second une constant representant le filtre appliqué

                Il ya deux type de filtres,
                    FILTER_SANITIZE_... return la variable assaini selon le filtre choisi
                    FILTER_VALIDATE_... return un boolean selon si la variable correspond ou non

            */
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
                $error["email"] = "Veuillez entrer un email valide";
        }
        if(empty($_POST["sujet"]))
            $error["sujet"] = "Veuillez entrer un sujet";
        else
        {
            $subject = cleanData($_POST["sujet"]);
            /*
                preg_match permet de verifier un string via une regex
                Il prendra en premier paramatre la regex en forme de string et en second le string a verifier
                Il retournera un, boolean.
            */
            if(!preg_match("/^[a-z éèàç]{5,}$/i", $subject))
                $error["sujet"] = "Certains carcateres ne sont pas accepté";
        }
        if(empty($post["corps"]))
            $error["corps"] = "Veuillez entrer un message";
        else
            $body = cleanData($_POST["corps"]);

        if(!isset($_POST["captcha"], $_SESSION["captchaStr"]) || $_POST["captcha"] != $_SESSION["captchaStr"])
            $error["captcha"] = "CAPTCHA Incorrect !";

        if(empty($error))
        {
            $envoi = sendMail(
                $email,
                "hystreak59@gmail.com",
                $subject,
                $body
            );
        }
    }

    function cleanData(string $data):string
    {
        $data = trim($data);
        $data = stripslashes($data);
        return htmlspecialchars($data);
    }
    $title = "Email";
    require "../ressources/template/_header.php";
    // J'affiche un message si mon envoie d'email s'est bien passé
    if(!empty($envoi)):
?>
<p>
    <?php echo $envoi ?>
</p>
<?php endif; ?>
<form action="" method="post">
    <input type="email" name="email" placeholder="Votre Email">
    <br>
    <span class="error"><?php echo $error["email"]??"" ?></span>
    <br>
    <input type="text" name="sujet" placeholder="Sujet de votre message">
    <br>
    <span class="error"><?php echo $error["sujet"]??"" ?></span>
    <textarea name="corps" placeholder="Votre message" cols="30" rows="10"></textarea>
    <br>
    <span class="error"><?php echo $error["corps"]??"" ?></span>
    <br>
    <div>
        <label for="captcha">Veuillez recopier le captcha</label>
        <br>
        <img src="../ressources/service/_captcha.php" alt="captcha">
        <br>
        <input type="text" name="captcha" id="captcha" pattern="[A-Z0-9]{6}">
        <br>
        <span class="error"><?php echo $error["captcha"]??"" ?></span>
    </div>
    <input type="submit" value="Envoyer" name="contact">
</form>
<?php 
require "../ressources/template/_footer.php";
?>