<!DOCTYPE html>
<html>

<head>
   <meta charset="UTF-8">
   <title>Inicio de Sesión</title>

   <style>
      body {
         font-family: Arial, sans-serif;
         background-color: #f4f4f4;
         margin: 0;
         padding: 0;
         display: flex;
         justify-content: center;
         align-items: center;
         height: 100vh;
      }

      .container {
         background: #fff;
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

      button:hover,
      a:hover {
         background: #0056b3;
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

         <label for="username">Usuario:</label>
         <input type="text" id="username" name="username">
         <label for="password">Contraseña:</label>
         <input type="password" id="password" name="password">
         <button type="submit" name="login">Iniciar Sesión</button>
      </form>
      <a href="registro.php">Registrarse</a>
      <a href="olvidar_contrasena.php">Olvidé mi contraseña</a>
   </div>
</body>


</html>