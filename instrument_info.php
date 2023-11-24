<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intrument info</title>

    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-between;
            margin: 20px;
            max-width: 800px;
            width: 100%;
            margin: 0 auto;
            /* Centra el contenedor horizontalmente */
        }

        .instrument {
            width: calc(33.33% - 20px);
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
            background-color: #fff;
            margin: 20px auto;
            /* Centra el instrumento horizontal y verticalmente */
            padding: 20px;
            /* Agrega un padding al contenido de la caja */
        }


        .instrument img {
            max-width: 100%;
            height: auto;
            border-bottom: 1px solid #ddd;
        }

        .instrument a {
            display: block;
            text-align: center;
            text-decoration: none;
            color: blue;
            transition: text-decoration 0.3s;
        }

        .instrument a:hover {
            text-decoration: underline;
        }


        nav {
            background-color: #333;
            color: white;
            padding: 10px;
            display: flex;
            align-items: center;
        }

        .nav-links {
            display: flex;
            gap: 20px;
            justify-content: left;
            align-items: center;
            flex: 1;
        }

        .nav-links div {
            display: inline;
        }

        nav a {
            text-decoration: none;
            color: white;
            transition: color 0.3s;
        }

        nav a:hover {
            color: yellow;
        }

        .menu-links {
            display: flex;
            gap: 20px;
            justify-content: flex-end;
        }

        header {
            background-color: #222;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
    </style>

</head>

<body>

    <?php
    session_start();

    $instrumentId = $_POST["instrument_id"];

    $user = 'root';
    $dbpassword = '';
    $dsn = 'mysql:dbname=bands;host=localhost';
    try {

        $dbconn = new PDO($dsn, $user, $dbpassword);

        // Consulta preparada para evitar inyección SQL
        $statement = $dbconn->prepare("SELECT * FROM instruments WHERE id = :id");

        $statement->bindParam(':id', $instrumentId);
        $statement->execute();

        // Obtener todas las filas como un array asociativo
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);


    } catch (PDOException $e) {
        $error_message = "Error de conexión a la base de datos: " . $e->getMessage();
    }

    ?>

    <header>
        <h1>Tienda de Instrumentos</h1>

        </h3>
    </header>

    <nav>
        <div class="nav-links">
            <div><a href="main_webpage.php">Inicio</a></div>
            <div><a href="#">Contacto</a></div>
            <div><a href="#">Buscar</a></div>
        </div>
        <div class="menu-links">
            <a href="logout.php">Cerrar sesión</a>
            <a href="newInstrument.php">Dar de alta instrumento</a>
        </div>
    </nav>

    <div class="container">

        <div class="instrument">

            <?php

            foreach ($array as $row) {
                ?>
                <img src='.<?php echo $row["image"]; ?>'>

                <?php echo '<p><b> Family: </b>' . $row["family"] . '</p>' ?>
                <?php echo '<p><b> Type: </b>' . $row["type"] . '</p>' ?>
                <?php echo '<p><b> Brand: </b>' . $row["brand"] . '</p>' ?>
                <?php echo '<p><b> Model: </b>' . $row["model"] . '</p>' ?>
                <?php echo '<p><b> Serial Number: </b>' . $row["serial_number"] . '</p>' ?>
                <?php echo '<p><b>Acquisition Date: </b>' . $row["acquisition_date"] . '</p>' ?>
                <?php echo '<p><b> State: </b>' . $row["state"] . '</p>' ?>
                <?php echo '<p><b> Comment: </b>' . $row["comment"] . '</p>' ?>

                <?php
            }
            ?>
            <a href="main_webpage.php">Volver a inicio</a>
        </div>


    </div>


</body>

</html>