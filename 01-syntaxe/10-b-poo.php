<?php
    /*
        Un des avantages de la POO est le fait de ne pas avoir à se soucier du nom de nos variables et fonctions qui sur un gros projet peuvent entrer en conflit
        $aaSuperClass=>travail() est different de $petiteclasse ->travail()

        Sur un tres gros projet utilisants enormements de bibliotheques le probleme des noms en commun peut se trouver sur les classes

        C'est ici qu'entre en jeu le namespace.
    */
    #-------------------------------Namespace et Use-----------------------------------------

    /*
        LEs namespaces sont un peu comme des dossiers virtuels
        On ne cree pas reelement de dossier, mais on range nos classes dans un chemin que l'on nomme comme on le souhaite.

        Le namespace se declare tout en haut du fichier avant tout autre code
        On utilise le mot clef namespace suivi du chemein choisi separé par des \
    */
    require "./10-a-poo.php";
    // class Enfant extends Humain{}
    // $hum = new Humain();
    /*
        Si je tente d'utiliser une classe de mon fichier precedent, que ce soit en instanciant ou heritant la classe. PHP ne la trouvera pas
        Pourquoi?
        Car tout en haut de mon fichier "a" j'ain indiqué que l'on se trouvait dans le namespace "Cours\POO"
        Or, cela mon fichier b l'ignore. Il ne trouve donc pas mes classes

        Pour retrouver ma classe, je dois indiquer le namespace, pour cela plusieurs solutions.

        1. indiquer le chemin complet du namespace a chaque fois que je veux utiliser ma classe
    */
    class Enfant extends Cours\POO\Humain{}
    $hum = new Cours\POO\Humain();
    // 2. utiliser le mot clef use pour indiquer a quoi fait reference ma classe "Humain"
    use Cours\POO\Humain;
    class Enfant extends Humain{}
    $hum2 = new Humain();
    //2.1 Si on a deux classe qui ont le meme nom on peut utiliser le mot clef as pour fair eun alias
    use Cours\POO\Humain as H;
    class Enfant extends H{}
    $hum3 = new H();

    /*
        Utiliser les namesspaces ne prive pas de devoir require le fichier ou se trouve notre classe.
        Mais sur les gros frameworks, on aura tendance a utiliser un autoloader qui detectera l'utilisation d'une classe.
        Puis ira require automatiquiement le fichier correspondant

        Pour faciliter le travail de l'autoloader on va generalement appelé un fichier par le nom de la classe qu'il contient ainsi que ranger le fichier dans des dossiers qui correspondent a son namespace

        Troisieme facon d'utiliser le namespace dans le fichier suivant :
    */
?>