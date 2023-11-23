<?php
session_start();


// Load Composer's autoloader
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['confirm']) && isset($_POST['email'])) {


    $email = $_POST['email'];














    // Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {

        // Recipients
        $mail->setFrom('paucalcas@alu.edu.gva.es', 'Admin');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(false);
        $mail->Subject = 'Password recovery.';
        $mail->Body = 'This is your password: ';
        $mail->send();

        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }


}


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="CSS/estiloLogin.css">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-image: url('../IMG/545752.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: white;
            width: 300px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin: 10px 0;
        }

        input {
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background: #007BFF;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        a {
            text-decoration: none;
            display: block;
            margin: 10px 0;
            color: #007BFF;
        }

        button:hover {
            background: #0056b3;
        }

        a:hover {
            text-decoration: underline;
        }

        .error {
            background-color: #ffcccc;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <form method="post" action="">
            <h2>Iniciar Sesión</h2>

            <?php include("checkLogin.php") ?>

            <label for="email"><b>Correo Electrónico</b></label>
            <input type="email" id="email" name="email" required>

            <button type="submit" name="confirm">Confirm</button>
        </form>

    </div>
</body>

</html>