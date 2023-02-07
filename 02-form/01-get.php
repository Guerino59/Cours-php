<?php
    $title = "Formulaire en get";
    require "../ressources/template/_header.php"

    
    if(isset($_GET["username"]))
    {
        var_dump($_GET["username"])
    }
?>
<form action="" method="get">
    <input type="text" placeholder = "Entrez un nom" name="username">
    <input type="submit" value="Envoyer">
</form>
<?php
    require "../ressources/template/_footer.php"
?>