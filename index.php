<?php


$erro = "";
$weather = "";

if (array_key_exists('submit', $_GET)) {
    //checando se o input está vazio
    if (!$_GET['city']) {
        $erro = "Desculpe, Preencha o campo cidade.";
    }
    if ($_GET['city']) {
        $apiData = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=" . $_GET['city'] . "&appid=");
        $weatherArray = json_decode($apiData, true);
        if ($weatherArray['cod'] == 200) {

            //C = K - 273.15
            $tempCelsius = $weatherArray['main']['temp'] - 273;
            $weather = "<b>" . $weatherArray['name'] . " - " . $weatherArray['sys']['country'] . "  " . intval($tempCelsius) . "&deg;C</b> <br>";
            $weather .= "<b>Weather Condition: </b>" . $weatherArray['weather']['0']['description'] . "<br>";
            $weather .= "<b>Atmosperic Pressure: </b>" . $weatherArray['main']['pressure'] . "hPa<br> ";
            $weather .= "<b>Wind speed: </b>" . $weatherArray['wind']['speed'] . "meter/sec<br>";
            $weather .= "<b>Cloudness: </b>" . $weatherArray['clouds']['all'] . "%<br>";
            date_default_timezone_set('America/Sao_Paulo');
            $sunrise = $weatherArray['sys']['sunrise'];
            $weather .= "<b>Date : </b>" . date("l jS \of F Y h:i:s A", $sunrise);
        } else {
            $erro = "Could 't be process, your city name is not valid.";
        }
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <title>Weather App</title>

</head>

<body>
    <div class="container">
        <h1>Seacrh Global Weather</h1>
        <form action="" method="GET">
            <p> <label for="Cidade">Enter your city name</label></p>
            <p><input type="text" name="city" id="city" placeholder="cidade"></p>
            <button type="submit" name="submit" class="btn btn-success">Submit Now</button>
            <div class="output mt-3">
                <?php
                if ($weather) {
                    echo '<div class="alert alert-success" role="alert">' . $weather . '</div>';
                }
                if ($erro) {
                    echo '<div class="alert alert-danger" role="alert">' . $erro . '</div>';
                }
                ?>

            </div>
        </form>
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>