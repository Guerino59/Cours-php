<?php
    $x = 5;
    $n = $x;
    while($x<$n+10)
    {
        $x++;
        echo $x, "<br>";
    }
    echo "<br>";
    $y = 3;
    for($i = 0; $i <= 9; $i++)
    {
        echo "$y * $i = ", $y*$i, "<br>";
    }
    echo "<br>";
    $z = 7;
    $f = 1;
    for($i = 1; $i <= $z; $i++)
    {
        $f *= $i;
    }
    echo $f;

    echo "<br>";
    $numbers=[1,2,3,4,5,36,7,8,9,10];
    $position = 0;
    $plusGrand = 0;
    echo '<pre>'.print_r($numbers, 1).'</pre>', "<br>";
    for($i=0; $i<count($numbers); $i++)
    {
        if($numbers[$i] > $plusGrand){
            $plusGrand = $numbers[$i];
            $position = $i;
        }
    }
    echo '<pre>'.print_r($numbers, 1).'</pre>', "<br>";
    echo "le plus grand nombre est $plusGrand et il se trouve à la position $position";

    echo "<br>";

    setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
    function frenchDate(){
        return strftime("%A %d %B %Y %H:%M:%S");
    }
    frenchDate();
    echo "<br>";
    session_start();
    if(!isset($_SESSION['date'], $_SESSION["time"])){
        $_SESSION["date"] = frenchDate();
        $_SESSION["time"] = time();
    }
    echo $_SESSION["date"];
    echo "<br>";
    echo time()-$_SESSION["time"]
