<?php 
if(!empty($_GET['location'])){

    $country_url = 'https://api.datoscovid.org/timeline/' . urlencode($_GET['location']);

    $country_json = file_get_contents($country_url);

    $country_array = json_decode($country_json, true);

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>David app</title>
</head>
<body>
    <form action="">
        <input type="text" name="location">
        <button type="submit">submit</button>
    </form>
    <?php
    
    if(!empty($country_array)){
        foreach ($country_array as $country){
            echo $country["Country"]. ", Fecha: "  . $country["Date"] . ", Casos confirmados: ". $country["Confirmed"] . ", Muertes: ". $country["Deaths"] . ", Recuperados: ". $country["Recovered"] . "<br>";
        }
    } else{
        echo "Busca un pais :)";
    }
    

     ?>
    
    
</body>
</html>