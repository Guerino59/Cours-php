<?php
    namespace Cours\POO;
    require "./10-a-poo.php";
    /*
        3.En travaillant dans le meme namespace que ma classe, on retrouvera celle ci directement
    */
    class Enfant extends Humain{};
    $hum = new Humain();
    /*
        Seul defaut de traviller dans un namespace precis, c'estr que l'orsqu'on veut uriliser une classe
        predefiniu en php, il ne la trouvera pas. La cherchant dans le namespace actuel.
    */
    // $ex = new Exception();

    // Pour corriger cela, on va simplement ajouter devan,t le nom de notre classe un \
    $ex = new \Exception();

    // Comme pour un chemin absolu ce \ indique de revenir a la racine de notre naespace
?>