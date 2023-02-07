<?php
    if(session_status() === PHP_SESSION_NONE)
    session_start();
    // Liste des caracteres accepté pour le captcha
    $characters ="ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    /**
     * Genere une chaine de caractere aleatoire
     * 
     * @param string $characters
     * @param integer $strength
     * @return string
     */
    function generateString(string $characters, int $strength = 10): string
    {
        $randStr = "";
        for($i=0; $i < $strength; $i++)
        {
            $randStr .= $characters[rand(0,strlen($characters)-1)];
        }
        return $randStr;
    }
    // genere une nouvelle image avec largeur hauteur qui est un objet de classe GdImage
    $image = imagecreatetruecolor(200, 50);
    // On active les fonctions d'antialias pour ameliorer la qualité de l'image
    imageantialias($image, true);

    $colors = [];
    // On choisi une plage de couleur aléatoire
    $red = rand(125, 175);
    $green = rand(125, 175);
    $blue = rand(125, 175);

    for($i = 0; $i <5; $i++)
    {
        /*
            imagecolorallate prend en premier argumanet un objet de classe GdImage.
            En second, troisieme et quatrieme argument des valeurs numerqie representant le rgb
            Elle retroune un int representant un identifiant pour la couleur generé
        */
        $colors[] = imagecolorallocate($image, $red - 20*$i, $green - 20*$i, $blue - 20*$i);
    }
    /*
        imagefill rempli un objet gdImage donné en premier argument, a poartir de position x et y en second et troisieme argument,
        avec l'identifiant de couleur donné en quatrieme argument
    */
    imagefill($image, 0, 0, $colors[0]);

    for($i = 0; $i <10; $i++)
    {
        // Parametre l'apaisseur d'une ligne de pixel pour une image donnée.
        imagesetthickness($image, rand(2,10));
        /*
            Dessine un rectangle pour l'image donne en premiere argument,
            avec les argument 2 et 3 pour la position de depart x et y puis les arguments 4 et 5 pour la position de fin x et y,
            de la couleur donnee en 6eme argument      
        */
        imagerectangle(
            $image,
            rand(-10, 190),
            rand(-10,10),
            rand(-10, 190),
            rand(40, 60),
            $colors[rand(1,4)]
        );
    }
    // Tableu de couleurs disponible pour le texte
    $textColors = [imagecolorallocate($image, 0, 0, 0), imagecolorallocate($image, 255, 255, 255)];
    // tableau de font diponible pour le texte
    $fonts = [__DIR__."/../font/Acme-Regular.ttf", __DIR__."/../font/arial.ttf", __DIR__."/../font/typewriter.ttf"];
    // Taille du captcha :
    $strLength = 6;
    $captchaStr = generateString($characters, $strLength);
    // Je sauvegarde le string aleatoire en session
    $_SESSION["captchaStr"] = $captchaStr;
    for($i = 0; $i< $strLength; $i++)
    {
        // On calcul l'espaacement ideal par rapport au nombre de lettre
        $letterSpace = 170/$strLength;
        // on choisi une position initial
        $initial = 15;
        /*
            imagettftext permet d'ecrire dans notre image en utilisant une police au format ttf.
            premier ,argument l'image dans laquelle ecrire
            second argument taille en pixel pour le texte
            troisieme argument un angle en degre
            quatrieme et cinquieme argument position x et y
            sixieme arg un couleur
            septieme arg une poilice d'ecriture
            huitieme arg le texte a ecrire
        */
        imagettftext(
            $image,
            24,
            rand(-15,15),
            $initial + $i*$letterSpace,
            rand(25, 45),
            $textColors[rand(0, 1)],
            $fonts[array_rand($fonts)],
            $captchaStr[$i]
        );
    }
    // On indique que le resultat de la requete à ce fichier retourne une image de type PNG.
    header("Content-type: image/png");
    // On transforme notre objet gfdImlage au format png:
    imagepng($image);
?>