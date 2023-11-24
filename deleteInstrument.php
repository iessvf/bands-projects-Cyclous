<?php
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["instrumentId"])) {
    $instrumentId = $_GET["instrumentId"];

    //CONECTION
    $user = 'root';
    $dbpassword = '';
    $dsn = 'mysql:dbname=bands;host=localhost';

    try {
        $dbconn = new PDO($dsn, $user, $dbpassword);


        //DELETE
        $query = "DELETE FROM instruments WHERE id = :instrumentId";
        $statement = $dbconn->prepare($query);
        $statement->bindParam(':instrumentId', $instrumentId, PDO::PARAM_INT);
        $statement->execute();

        echo "Instrumento eliminado correctamente";

    } catch (PDOException $e) {
        echo "Error al eliminar el instrumento: " . $e->getMessage();
    }
} else {
    // Si no es una solicitud GET válida, redirige o responde según sea necesario
    header("Location: tu_pagina_de_error.php");
    exit();
}
?>