<?php
    session_start();

    if (isset($_SESSION['loggedin'])){
        header('Location: index.php');
        exit;
    }

    require 'functions.php';

    if (isset($_POST['lsubmit'])) {
        
        $uname = $_POST['luname'];
        $pass = $_POST['lpw'];

        $checkUser = mysqli_query($dbConn, "SELECT * FROM users WHERE username = '$uname'");

        if (mysqli_num_rows($checkUser) == 1) {
            $user = mysqli_fetch_assoc($checkUser);
            if (password_verify($pass, $user["password"])) {
                $_SESSION["loggedin"] = true;
                header("Location: index.php");
                exit;
            }
        }

        $error = true;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
</head>
<body>
    
    <h1>Login Page</h1>

     
    <?php if (isset($error)) : ?>
        <p style="color: red; font-family: Arial, Helvetica, sans-serif;">Username / Password is incorrect.</p>
    <?php endif; ?>

    <form method="post">
        <ul>
            <li>
                <label for="luname">Username : </label>
                <input type="text" name="luname" id="luname">
            </li>

            <li>
                <label for="lpw">Password : </label>
                <input type="password" name="lpw" id="lpw">
            </li>

            <br>
            <button type="submit" name="lsubmit">Login</button>
        </ul>
    </form>

</body>
</html>