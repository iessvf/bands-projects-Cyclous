<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 50px;
        }

        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #cccccc;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            color: #ffffff;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        a {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>

</head>

<body>
    <form action="registro.php" method="post"><input type="text" name="usuario" placeholder="Usuario"><input
            type="password" name="contraseña" placeholder="Contraseña"><input type="submit" value="Registrarse"><a
            href="login.php">¿Ya tienes una cuenta? Inicia sesión aquí</a></form>
</body>

</html>