<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['id'])) {
    // Si no hay una sesión válida, redirige al inicio de sesión
    header("Location: main_webpage.php");
    exit();
}

$user = 'root';
$dbpassword = '';
$dsn = 'mysql:dbname=bands;host=localhost';

try {
    $dbconn = new PDO($dsn, $user, $dbpassword);

    // Construir la consulta base
    $query = "SELECT * FROM instruments WHERE band_id = :band_id";

    // Parámetros para la consulta
    $params = array(':band_id' => $_SESSION['id']);

    // Verificar y agregar condiciones de búsqueda según los parámetros enviados por POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['family']) && !empty($_POST['family'])) {
            $query .= " AND family = :family";
            $params[':family'] = $_POST['family'];
        }

        if (isset($_POST['brand']) && !empty($_POST['brand'])) {
            $query .= " AND brand LIKE :brand";
            $params[':brand'] = '%' . $_POST['brand'] . '%';
        }

        if (isset($_POST['model']) && !empty($_POST['model'])) {
            $query .= " AND model LIKE :model";
            $params[':model'] = '%' . $_POST['model'] . '%';
        }

        if (isset($_POST['serial_number']) && !empty($_POST['serial_number'])) {
            $query .= " AND serial_number LIKE :serial_number";
            $params[':serial_number'] = '%' . $_POST['serial_number'] . '%';
        }

        if (isset($_POST['available'])) {
            $query .= " AND state = 'available'";
        }

        if (isset($_POST['lent'])) {
            $query .= " AND state = 'lent'";
        }
    }

    // Preparar la consulta con las condiciones de búsqueda
    $statement = $dbconn->prepare($query);
    $statement->execute($params);

    // Obtener todas las filas como un array asociativo
    $array = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Devolver los resultados como JSON (puedes ajustar según tus necesidades)
    echo json_encode($array);

} catch (PDOException $e) {
    // Manejar errores de conexión a la base de datos
    $error_message = "Error de conexión a la base de datos: " . $e->getMessage();
    echo json_encode(array('error' => $error_message));
}
?>