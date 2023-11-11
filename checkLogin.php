<?php
session_start();
$showError = false; // Variable de bandera para controlar si se muestra el mensaje de error

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Verificar si ambos campos están vacíos o si uno de ellos está vacío
    if (empty($username) || empty($password)) {
        if (empty($username)) {
            $showError = true;
            echo '<span class="error">El campo Usuario no puede estar vacío.</span>';
        }

        if (empty($password)) {
            $showError = true;
            echo '<span class="error">El campo Contraseña no puede estar vacío.</span>';
        }
    } else {
        $user = 'root';
        $dbpassword = '';
        $dsn = 'mysql:dbname=bands;host=localhost';

        try {
            $dbconn = new PDO($dsn, $user, $dbpassword);

            // Consulta preparada para evitar inyección SQL
            $statement = $dbconn->prepare("SELECT * FROM bands WHERE username = :username");
            $statement->bindParam(':username', $username);
            $statement->execute();

            // Comprobar si se encontró un usuario
            if ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                // Usuario encontrado, ahora verifica la contraseña
                if ($row['password'] === $password) {

                    $id = $row['id'];

                    // Crear la sesión con el nombre de usuario e ID
                    $_SESSION['username'] = $username;
                    $_SESSION['id'] = $id;

                    header("Location: main_webpage.php");
                    exit();
                } else {
                    echo '<span class="error">Credenciales incorrectas.</span>';
                }
            } else {
                echo '<span class="error">Usuario no encontrado.</span>';
            }
        } catch (PDOException $e) {
            echo "Error de conexión a la base de datos: " . $e->getMessage();
        }
    }
}
?>