<?php
if(session_status() === PHP_SESSION_NONE)
session_start();
/*
    Parametre un token en session et ajoute un inpute hiddent contenant le token
    Optionnellement, prend uine duree de vie pour le jeton.
*/
function setCSRF(int $time = 0):void
{
    // Si le temps est superieur à 0, on parametre un timestamp d'expiration
    if($time > 0)
    $_SESSION["tokenExpire"] = time() + 60*$time;
    /*
        random_bytes va retourner un nombre d'octet aleatoir d'une longueur donne en parametre
        bin2hex va reconvertir des donnes binaires en hexadecimal.
    */
    $_SESSION["token"] = bin2hex(random_bytes(50));
    // On affcihe un inpute de type hident ayant pour valeur notre jeton.
    echo "<input type='hidden' name='token' value='".$_SESSION['token']."'>";
}
/*
    Verifie si le jeton est toujours valide
*/
function isCSRFValid(): bool
{
    // Si il n'y  a pas de date d'expiration ou si elle n'est pas depassé
    if(!isset($_SESSION["tokenExpire"]) || $_SESSION["tokenExpire"] > time())
    {
        // Si notre token existe et qu'il est bien eagale a celui envoyé en post
        if(isset($_SESSION["token"], $_POST["tokken"]) && $_SESSION["token"] === $_POST["token"])
        return true;
        // alors on retourne true, sinon on retourne false
    }
    // On indique un code de status montrant que ce qui a été tenté n'est pas valide
    header($_SERVER["SERVER_PROTOCOL"]. " 405 METHOD NOT ALLOWED");
    return false;

}
function cleanData(string $data):string
    {
        $data = trim($data);
        $data = stripslashes($data);
        return htmlspecialchars($data);
    }
?>