<?php
/*
        Reseumons ce que l'on a vu :
            1. Il est important de placer le fichier contenant vos informations de connexion, dans un dossier innaccessibles aux utilisateurs.
            2. Au lieu de repeter a chaque fois la connexion à la BDD dans chaque fichier ou vous en avez besoin.
                On peut se contenter de le faire dans un fichier externe importé
            3. Si des informations rentree par l'utilisateur qont requise dans votre sql.
                Il faut faire un requetez preparée afin d'eviter les injections SQL.
            
    */

// connexion à la BDD :
$pdo = new PDO(
    "mysql:host=localhost;port=3306;dbname=bieres;charset=utf8mb4",
    "root",
    "",
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // PDO::ATTR_EMULATE_PREPARES => false
    ]
);
// Vous retrouverez les commentaires detaillés dans le fichier _pdo.php

// requete simple
$sql = $pdo->query("SELECT * FROM couleur");
echo '<pre>' . print_r($sql->fetchAll(), 1) . '<pre>';

// requete preparé anonyme :

$sql = $pdo->prepare("SELECT * FROM couleur WHERE NOM_COULEUR = ?");
$sql->execute(["Blanche"]);
echo '<pre>' . print_r($sql->fetch(), 1) . '<pre>';

// Requete preparée nommée
$sql = $pdo->prepare("SELECT * FROM couleur WHERE NOM_COULEUR = :col");
$sql->execute(["col" => "Brune"]);
echo '<pre>' . print_r($sql->fetch(), 1) . '<pre>';

/*
    Pour la methode execute il n'y a que deux types possibl;es
    *string ou null
    Parfois on a besoin de plus de precision

    Par exemple si on laisse activé l'emulation des requetes preparés de PDO
    On va avoir un probleme si on execute un parametre avec LIMIT
    Ce dernier n'accepte que les chiffres et execute transforme notre chiffre en string
*/
$sql = $pdo->prepare("SELECT * FROM couleur LIMIT :lim");
//provoque une erreur
// $sql->execute(["lim" => 10]);

/*
    Pour passer outre cette erreur, il va falloir indiquer le titre du parametre.
    Pour cela on va utiliser les methodes bindValue ou bindParam;
    On peut leur indiquer le type du paramaetre via les constantes suivantes :
        - PDO::PARAM_NULL
        - PDO::PARAM_BOOL
        - PDO::PARAM_INT
        - PDO::PARAM_STR
*/
$sql->bindValue("lim", 2, PDO::PARAM_INT);
$sql->execute();
// On ne peut pas à la fois bind des parametres et en donner a execute

echo '<pre>' . print_r($sql->fetchAll(), 1) . '<pre>';
//La principale difference entre bindValue et biendParam se fera au niveau de quand la valur sera enregistré

$couleur = "Blanche";
$sql = $pdo->prepare("SELECT * FROM couleur WHERE NOM_COULEUR = :col");
$sql->bindValue("col", $couleur, PDO::PARAM_STR);
$couleur = "Ambrée";
$sql->execute();
echo '<pre>' . print_r($sql->fetchAll(), 1) . '<pre>';
/* 
    bindValue va lier à la requete la valeur de la variable à l'instanty ou elle est utilisé.
    Alors que binfdParam va lier à la requete la varaible et ne recupere que sa valeur au moment de l'execute
*/
$couleur = "Blanche";
$sql = $pdo->prepare("SELECT * FROM couleur WHERE NOM_COULEUR = :col");
$sql->bindParam("col", $couleur, PDO::PARAM_STR);
$couleur = "Ambrée";
$sql->execute();
echo '<pre>' . print_r($sql->fetchAll(), 1) . '<pre>';
