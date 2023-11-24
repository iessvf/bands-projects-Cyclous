<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="CSS/signup.css">
</head>

<?php
if (isset($_POST['register'])) {
    $username = $_POST['username'] ?? "";
    $password = $_POST["password"] ?? "";
    $password_confirm = $_POST["password_confirm"] ?? "";
    $name = $_POST["name"] ?? "";
    $mail = $_POST["email"] ?? "";
    $logo = $_FILES["logo"] ?? "";



    $firstTime = false;

} else {
    $firstTime = true;
}
?>

<body>
    <div class="container">
        <h2>Register</h2>

        <form action="" method="post" enctype="multipart/form-data">
            <label for="username"><b>Username</b></label>


            <?php
            if (!$firstTime && !empty($error_message)) {
                echo '<p class="error">' . $error_message . '</p>';
            }
            ?>

            <?php


            //USERNAME CHECK
            if (!$firstTime && empty($username)) {
                echo '<p class="error">Username field can not be empty.</p>';

            } else if (!$firstTime && strlen($username) < 4) {
                echo '<p class="error">Username has to be at least size 4.</p>';

            } else if (!$firstTime && strlen($username) >= 4) {
                $validUserName = $username;

            }

            ?>

            <input type="text" class="form-control" name="username" value="<?php if (isset($_POST['username']))
                echo $_POST['username']; ?>" placeholder=" Write...">


            <?php
            if (!$firstTime && !empty($error_message)) {
                echo '<p class="error">' . $error_message . '</p>';
            }
            ?>

            <label for="password"><b>Password</b></label>
            <?php

            //PASSWORD CHECK
            if (!$firstTime && empty($password)) {
                echo '<p class="error">This field can not be empty.</p>';
            }


            ?>

            <input type="password" class="form-control" name="password" placeholder="Write...">
            <label for="password"><b>Confirm password</b></label>

            <?php

            $confirmedPassword = false;

            //CHECK CONFIRM PASSWORD
            if (!$firstTime && empty($password)) {

                echo '<p class="error">This field can not be empty.</p>';

            } else if (!$firstTime && $password !== $password_confirm) {

                echo '<p class="error">Password must match.</p>';
            } else if (!$firstTime && $password === $password_confirm) {

                $confirmedPassword = true;

            }
            ?>
            <input type="password" class="form-control" name="password_confirm" placeholder="Write...">



            <label for="name"><b>Name</b></label>

            <?php if (!$firstTime && empty($name)) {

                echo '<p class="error">This field can not be empty.</p>';

            }
            ?>

            <input type="text" class="form-control" name="name" placeholder="Write...">

            <label for="email"><b>Email</b></label>

            <?php if (!$firstTime && empty($email)) {

                echo '<p class="error">This field can not be empty.</p>';

            }
            ?>

            <input type="email" class="form-control" name="email" placeholder="Write...">
            <input type="file" class="form-control btn-upload" name="logo" accept=".jpg, .jpeg, .png">
            <button type="submit" name="register" class="btn">Register</button>
            <div class="login_link"><a href="login.php">Go back to log in</a></div>


        </form>
    </div>
</body>

</html>

<?php
if (isset($_POST["register"])) {
    if (empty($username) || empty($password) || !$confirmedPassword || empty($mail) || empty($_FILES["logo"]["tmp_name"])) {
        $error_message = "All fields are required.";
        echo '<p class="error">' . $error_message . '</p>';
    } else {
        // Imagen
        $img_name = $_FILES['logo']['name'];
        $img_tmp_name = $_FILES['logo']['tmp_name'];

        $upload_dir = "./uploads/profile/";
        $target_path = $upload_dir . $img_name;

        if (move_uploaded_file($img_tmp_name, $target_path)) {
            $image = "/uploads/profile/{$img_name}";

            $user = 'root';
            $dbpassword = '';
            $dsn = 'mysql:dbname=bands;host=localhost';

            try {
                $dbconn = new PDO($dsn, $user, $dbpassword);

                // SQL for INSERT
                $statement = $dbconn->prepare("INSERT INTO bands (username, password, name, mail, logo) VALUES (:username , :password, :name, :mail, :logo)");

                $statement->bindParam(':username', $username);
                $statement->bindParam(':password', $password);
                $statement->bindParam(':name', $name);
                $statement->bindParam(':mail', $mail);
                $statement->bindParam(':logo', $image);
                $statement->execute();

                header('Location:login.php');
            } catch (PDOException $e) {
                $error_message = "Error: " . $e->getMessage();
                echo '<p class="error">' . $error_message . '</p>';
            }
        } else {
            echo '<p class="error">Failed to move the uploaded file.</p>';
        }
    }
}
?>