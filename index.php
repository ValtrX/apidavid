<?php
if (!empty($_GET['location'])) {

    $country_url = 'https://api.datoscovid.org/timeline/' . urlencode($_GET['location']);

    $country_json = file_get_contents($country_url);

    $country_array = json_decode($country_json, true);

    /* Convertimos Fechas a un array desde el array de cada pais */
    $fechas = array_column($country_array, 'Date');

    $confirmados = array_column($country_array, 'Confirmed');

    $muertos = array_column($country_array, 'Deaths');

    $recuperados = array_column($country_array, 'Recovered');

}

$countries_url = 'https://api.datoscovid.org/country';

$countries_json = file_get_contents($countries_url);

$countries_array = json_decode($countries_json, true);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>David app</title>
    <link rel="icon" type="image/png" href="img/David animado.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
</head>

<body>


<!-- Seccion de busqueda -->
<section id="busqueda" class="text-center m-5">

    <form action="">
        <label for="country" class="label"><h2>Selecciona un pais: </h2></label>
        <select name="location" id="location" style="font-size: 2vh;">
            <?php
            /* Array para seleccionar cada pais se envia en $_GET[] a la url*/
            sort($countries_array);
            foreach ($countries_array as $country_input) {
                echo "<option value='" . $country_input['Country'] . "'>" . $country_input['Country'] . "</option>";

            }?>
        </select>
 
        <br><br>
        <button type="submit" value="Submit" class="btn btn-success btn-lg rounded-0">Buscar</button>
    </form>

</section>
    <?php

/* Mostrando los datos de cada pais dependiendo del pais que escojas */

if (!empty($country_array)) { // Si hay un pais seleccionado haz esto:
    ?>

    <div style="width: 600px; height: 600px;" class="m-auto">
        <canvas id="myChart" width="400" height="400"></canvas>
        <script>
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($fechas); ?> ,
                    datasets : [{
                        label: 'Casos Confirmados',
                        data: <?php echo json_encode($confirmados); ?> ,
                        fill : false,
                        backgroundColor: '#2258e0',
                        borderColor: '#2258e0',
                        pointRadius: 0,

                    }, {
                        label: 'Muertos',
                        data: <?php echo json_encode($muertos); ?> ,
                        fill : false,
                        backgroundColor: '#ff0000',
                        borderColor: '#ff0000',
                        pointRadius: 0,

                    }, {
                        label: 'Recuperados',
                        data: <?php echo json_encode($recuperados); ?> ,
                        fill : false,
                        backgroundColor: '#82e65e',
                        borderColor:  '#82e65e',
                        pointRadius: 0,

                    }],

                },
                options: {
                    hover: {
                        mode: 'nearest',
                        intersect: true
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        </script>
    </div>

    <?php } else {
    echo "<h3 class='text-center'>Busca un pais :)</h3>";
}?>



    <script type="text/javascript">
        document.getElementById('location').value = "<?php echo $_GET['location']; ?>";
    </script>

</body>

</html>