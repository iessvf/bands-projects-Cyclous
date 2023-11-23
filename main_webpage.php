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
    $array = array();

    try {
        $dbconn = new PDO($dsn, $user, $dbpassword);

        // Construir la consulta base
        $query = "SELECT * FROM instruments WHERE band_id = :band_id ";

        // Inicializar los valores de estado
        $available = null;
        $lent = null;

        // Verificar si se ha enviado un formulario de búsqueda
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_by'])) {
            $family = isset($_POST['family']) ? $_POST['family'] : null;
            $brand = isset($_POST['brand']) ? $_POST['brand'] : null;
            $model = isset($_POST['model']) ? $_POST['model'] : null;
            $serial_number = isset($_POST['serial_number']) ? $_POST['serial_number'] : null;

            // Estado por defecto es null
            $available = null;
            $lent = null;

            // Verificar si se seleccionó el estado
            if (isset($_POST['status']) && is_array($_POST['status'])) {
                foreach ($_POST['status'] as $status) {
                    if ($status === 'available') {
                        $available = 1;
                    } elseif ($status === 'lent') {
                        $lent = 1;
                    }
                }
            }

            // Agregar condiciones a la consulta si se seleccionó algún filtro
            if (!empty($family)) {
                $query .= " AND family = :family";
            }

            if (!empty($brand)) {
                $query .= " AND brand = :brand";
            }

            if (!empty($model)) {
                $query .= " AND model = :model";
            }

            if (!empty($serial_number)) {
                $query .= " AND serial_number = :serial_number";
            }

            // Agregar condiciones de estado si se seleccionó algún estado
            if (!is_null($available) || !is_null($lent)) {
                $query .= " AND (state = :available OR state = :lent)";
            }
        }

        $statement = $dbconn->prepare($query);

        // Bindear parámetros
        $statement->bindParam(':band_id', $band_id);

        if (!empty($family)) {
            $statement->bindParam(':family', $family);
        }

        if (!empty($brand)) {
            $statement->bindParam(':brand', $brand);
        }

        if (!empty($model)) {
            $statement->bindParam(':model', $model);
        }

        if (!empty($serial_number)) {
            $statement->bindParam(':serial_number', $serial_number);
        }

        if (!is_null($available) || !is_null($lent)) {
            $statement->bindParam(':available', $available);
            $statement->bindParam(':lent', $lent);
        }

        $statement->execute();

        // Obtener todas las filas como un array asociativo
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);

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

</head>

<body>
    <header>
        <h1>
            <?php echo $username; ?>
        </h1>



    </header>

    <nav>
        <div class="nav-links">
            <div><a href="main_webpage.php">Home</a></div>
            <div><a href="newInstrument.php">New instrument</a></div>
            <div><a href="#">Help</a></div>
        </div>
        <div class="menu-links">
            <a href="logout.php">Close session</a>
        </div>
    </nav>

    <aside>
        <h2>Search</h2>
        <form action="" method="POST">
            <label for="family">Family: </label>
            <select name="family">
                <option value="" hidden>- Select -</option>
                <option value="brass">Brass</option>
                <option value="wood">Wood</option>
                <option value="strings">Strings</option>
                <option value="percussion">Percussion</option>
            </select>
            <label for="brand">Brand: </label>
            <input type="text" name="brand" id="brand" placeholder="Enter brand">

            <label for="model">Model: </label>
            <input type="text" name="model" id="model" placeholder="Enter model">

            <label for="serial_number">Serial Number: </label>
            <input type="text" name="serial_number" id="serial_number" placeholder="Enter serial number">

            <div class="status-checkboxes">
                <label for="status">Status:</label>
                <input type="checkbox" name="status[]" id="available" value="available">
                <label for="available">Available</label>

                <input type="checkbox" name="status[]" id="lent" value="lent">
                <label for="lent">Lent</label>
            </div>

            <button type="submit" name="search_by">Search</button>
        </form>
    </aside>




    <main>
        <div class="container">
            <?php
            foreach ($array as $row) {
                ?>
                <div class="instrument">

                    <button class="delete-button" onclick="showConfirmation('<?php echo $row['id']; ?>')">X</button>
                    <h3>
                        <?php
                        echo $row["brand"] . ' ' . $row["model"] . ' - ';
                        $statusColor = ($row["state"] == 'available') ? 'available' : 'lent';
                        echo '<span class="instrument-status ' . $statusColor . '">' . $row["state"] . '</span>';
                        ?>
                    </h3>
                    <img src='.<?php echo $row["image"]; ?>'>
                    <form action="instrument_info.php" method="post">
                        <input type="hidden" name="instrument_id" value="<?php echo $row["id"]; ?>">
                        <button class="showMore" type="submit">+info</button>
                    </form>
                </div>
                <?php
            }
            ?>
        </div>
    </main>

    <footer>
        <p>Información personal - Nombre, dirección, contacto, etc.</p>
    </footer>

    <script>
        function showConfirmation(instrumentId) {
            var confirmDelete = confirm("¿Estás seguro de que quieres eliminar este instrumento?");
            if (confirmDelete) {
                window.location.href = "deleteInstrument.php?instrumentId=" + instrumentId;
                alert("Instrumento eliminado");
            } else {

                alert("Eliminación cancelada");
            }
        }
    </script>
</body>

</html>