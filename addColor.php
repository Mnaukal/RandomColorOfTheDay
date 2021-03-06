<?php
try {
    $dbData = parse_ini_file("config.ini");

    $dbh = new PDO("mysql:host={$dbData['hostname']};dbname={$dbData['dbname']}", $dbData['username'], $dbData['password']);
    /*** echo a message saying we have connected ***/
    
    $color = sprintf ("%06X", mt_rand(0, 0xffffff));
    
    $date = date("Y-m-d");
    
    /*** INSERT data ***/
    $count = $dbh->exec("INSERT INTO colors(color, date) VALUES ('$color', '$date')");

    /*** echo the number of affected rows ***/
    //echo $count;
    
    //header("Content-type: image/png");
    $im     = imagecreatefrompng("color.png");
    
    $r = hexdec(substr($color, 0, 2));
    $g = hexdec(substr($color, 2, 2));
    $b = hexdec(substr($color, 4, 2));
    
    $col = imagecolorallocate($im, $r, $g, $b);
    imagefill($im, 0, 0, $col);
    imagepng($im, "color.png");
    imagedestroy($im);
    

    /*** close the database connection ***/
    $dbh = null;
    
    echo ($color);
}
catch(PDOException $e)
{
    echo $e->getMessage();
}
?>