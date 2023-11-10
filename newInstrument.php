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
        <form action="" method="post">
            <input type="text" class="form-control" name="family" placeholder="Familia" required>
            <input type="text" class="form-control" name="type" placeholder="Tipo" required>
            <input type="text" class="form-control" name="brand" placeholder="Marca" required>
            <input type="text" class="form-control" name="model" placeholder="Modelo" required>
            <input type="text" class="form-control" name="serial_number" placeholder="Número de serie" required>
            <input type="date" class="form-control" name="acquisition_date" placeholder="Fecha de adquisición" required>
            <input type="text" class="form-control" name="state" placeholder="Estado" required>
            <textarea class="form-control" name="comment" placeholder="Comentario"></textarea>
            <input type="file" class="form-control btn-upload" name="image" accept="image/*">
            <button type="submit" class="btn">Registrar Instrumento</button>
            <a href="main_webpage.php">Volver al inicio</a>
        </form>
    </div>
</body>

</html>