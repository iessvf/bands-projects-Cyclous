<!DOCTYPE html>
<html>

<head>
   <meta charset="UTF-8">
   <title>Inicio de Sesión</title>

   <link rel="stylesheet" href="CSS/estiloLogin.css">
</head>

<body>
   <div class="container">
      <form method="post" action="">
         <h2>Iniciar Sesión</h2>

         <?php include("checkLogin.php") ?>

         <label for="username"><b>Usuario</b></label>
         <input type="text" id="username" name="username">
         <label for="password"><b>Contraseña</b></label>
         <input type="password" id="password" name="password">
         <button type="submit" name="login">Iniciar Sesión</button>
      </form>
      <a href="signup.php">Registrarse</a>
      <a href="olvidar_contrasena.php">Olvidé mi contraseña</a>
   </div>
</body>


</html>