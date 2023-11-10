<?php
session_start();

// Verificar si la sesión del usuario existe y contiene la variable 'username'
if (isset($_SESSION['username']) && isset($_SESSION['id'])) {
    // Obtén el nombre de usuario desde la sesión
    $username = $_SESSION['username'];
    $band_id = $_SESSION['id'];

    $user = 'root';
    $dbpassword = '';
    $dsn = 'mysql:dbname=bands;host=localhost';
    try {
        $dbconn = new PDO($dsn, $user, $dbpassword);

        // Consulta preparada para evitar inyección SQL
        $statement = $dbconn->prepare("SELECT image FROM instruments WHERE band_id = :band_id");

        $statement->bindParam(':band_id', $band_id);
        $statement->execute();

        // Obtener todas las filas como un array asociativo
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        $error_message = "Error de conexión a la base de datos: " . $e->getMessage();
    }
} else {
    // Si la sesión no contiene 'username', redirige de nuevo a la página de inicio de sesión
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Instrumentos</title>
    <link rel="stylesheet" href="./CSS/main_webpage.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-between;
            margin: 20px;
        }

        .instrument {
            width: calc(33.33% - 20px);
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
            background-color: #fff;
        }

        .instrument:hover {
            transform: scale(1.05);
        }

        .instrument img {
            max-width: 100%;
            height: auto;
            border-bottom: 1px solid #ddd;
        }

        .instrument-info {
            padding: 10px;
            text-align: left;
            /* Alinea el texto a la izquierda */
            margin-top: 10px;
            /* Ajusta el espacio entre la imagen y la información */
        }
    </style>
</head>

<body>
    <header>
        <h1>Tienda de Instrumentos</h1>
        <h3>Bienvenido,
            <?php echo $username; ?>
        </h3>
    </header>

    <nav>
        <div class="nav-links">
            <div><a href="#">Inicio</a></div>
            <div><a href="#">Contacto</a></div>
            <div><a href="#">Buscar</a></div>
        </div>
        <div class="menu-links">
            <a href="logout.php">Cerrar sesión</a>
            <a href="newInstrument.php">Dar de alta instrumento</a>
        </div>
    </nav>

    <aside>
        <h2>Filtro Lateral</h2>
        <ul>
            <li><a href="#">Guitarras</a></li>
            <li><a href="#">Pianos</a></li>
            <li><a href="#">Baterías</a></li>
            <li><a href="#">Amplificadores</a></li>
        </ul>

        <h2>Marcas</h2>
        <ul>
            <li><a href="#">Fender</a></li>
            <li><a href="#">Gibson</a></li>
            <li><a href="#">Yamaha</a></li>
            <li><a href="#">Ibanez</a></li>
        </ul>
    </aside>

    <main>
        <div class="container">
            <?php
            foreach ($result as $key => $image) {
                echo '<div class="instrument">';
                echo '<img src="' . $image['image'] . '" alt="Instrument Image">';
                echo '<div class="instrument-info">';
                echo '<p><strong>Familia:</strong> Guitarra</p>';
                echo '<p><strong>Tipo:</strong> Acústica</p>';
                echo '<p><strong>Marca:</strong> Fender</p>';
                echo '<p><strong>Modelo:</strong> Stratocaster</p>';
                echo '<p><strong>Número de Serie:</strong> 123456789</p>';
                echo '<p><strong>Día de Adquisición:</strong> 2023-11-10</p>';
                echo '<p><strong>Estado:</strong> Nuevo</p>';
                echo '<p><strong>Comentario:</strong> Una descripción del instrumento.</p>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </main>



    <footer>
        <p>Información personal - Nombre, dirección, contacto, etc.</p>
    </footer>
</body>

</html>