<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Instrumento</title>

    <link rel="stylesheet" href="./CSS/new_instrument.css">

</head>

<body>
    <div class="container">
        <h2>Registro de Instrumento</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="text" class="form-control" name="family" placeholder="Familia" required>
            <input type="text" class="form-control" name="type" placeholder="Tipo" required>
            <input type="text" class="form-control" name="brand" placeholder="Marca" required>
            <input type="text" class="form-control" name="model" placeholder="Modelo" required>
            <input type="text" class="form-control" name="serial_number" placeholder="Número de serie" required>
            <input type="date" class="form-control" name="acquisition_date" placeholder="Fecha de adquisición" required>
            <input type="text" class="form-control" name="state" placeholder="Estado" required>
            <textarea class="form-control" name="comment" placeholder="Comentario"></textarea>
            <input type="file" class="form-control btn-upload" name="image" accept=".jpg, .jpeg, .png">
            <button type="submit" class="btn" name="register_newInstrument">Registrar Instrumento</button>
            <a href="main_webpage.php">Volver al inicio</a>
        </form>
    </div>
</body>

</html>

<?php

session_start();

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];

}
if (isset($_POST["register_newInstrument"])) {



    if (!empty($_POST["family"]) && !empty($_POST["type"]) && !empty($_POST["brand"]) && !empty($_POST["model"]) && !empty($_POST["serial_number"]) && !empty($_POST["acquisition_date"]) && !empty($_POST["state"]) && !empty($_POST["comment"]) && !empty($_FILES["image"]["tmp_name"])) {


        $family = $_POST["family"];
        $type = $_POST["type"];
        $brand = $_POST["brand"];
        $model = $_POST["model"];
        $serial_number = $_POST["serial_number"];
        $acquisition_date = $_POST["acquisition_date"];
        $state = $_POST["state"];
        $comment = $_POST["comment"];


        //Imagen
        $img_name = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "./uploads/instruments/{$img_name}");
        $image = "/uploads/instruments/{$img_name}";



        $user = 'root';
        $dbpassword = '';
        $dsn = 'mysql:dbname=bands;host=localhost';

        try {

            $dbconn = new PDO($dsn, $user, $dbpassword);

            // Inserción preparada 
            $statement = $dbconn->prepare("INSERT INTO instruments (family,type,brand,model,serial_number,acquisition_date,state,comment,image,band_id) 
                                    VALUES (:family, :type,:brand ,:model, :serial_number, :acquisition_date,:state,:comment,:image,:id)");

            $statement->bindParam(':family', $family);
            $statement->bindParam(':type', $type);
            $statement->bindParam(':brand', $brand);
            $statement->bindParam(':model', $model);
            $statement->bindParam(':serial_number', $serial_number);
            $statement->bindParam(':acquisition_date', $acquisition_date);
            $statement->bindParam(':state', $state);
            $statement->bindParam(':comment', $comment);
            $statement->bindParam(':image', $image);
            $statement->bindParam(':id', $id);
            $statement->execute();


            header('Location:main_webpage.php');
        } catch (PDOException $e) {

            $mensajeError = $e->getMessage();
            echo "Error: " . $mensajeError;
        }


    }

}






?>