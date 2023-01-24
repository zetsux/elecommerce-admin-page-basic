<?php
    session_start();
    require 'functions.php';

    if (isset($_COOKIE['log1']) && isset($_COOKIE['log2'])){
        $cid = $_COOKIE['log1'];
        $chash = $_COOKIE['log2'];

        $checkUser = mysqli_query($dbConn, "SELECT username FROM users WHERE id = $cid");
        $cuser = mysqli_fetch_assoc($checkUser);

        if ($chash === hash('haval160,5', $cuser["username"])) {
            $_SESSION['loggedin'] = true;
        }
    }

    if (isset($_SESSION['loggedin'])){
        header('Location: index.php');
        exit;
    }

    if (isset($_POST['lsubmit'])) {
        
        $uname = $_POST['luname'];
        $pass = $_POST['lpw'];

        $checkUser = mysqli_query($dbConn, "SELECT * FROM users WHERE username = '$uname'");

        if (mysqli_num_rows($checkUser) == 1) {
            $user = mysqli_fetch_assoc($checkUser);
            if (password_verify($pass, $user["password"])) {
                $_SESSION["loggedin"] = true;

                if (isset($_POST["rmb"])) {
                    setcookie("log1", $user["id"], time() + 1800);
                    setcookie("log2", hash('haval160,5', $user["username"]), time() + 1800);
                }

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
                <label style="padding: 0px 1.5px;" for="lpw">Password : </label>
                <input type="password" name="lpw" id="lpw">
            </li>

            <br>
            <button type="submit" name="lsubmit">Login</button>

            <div style="padding: 0px 0px 10px 77px; display: inline-block">
                <input type="checkbox" name="rmb" id="rmb">
                <label for="rmb">Remember Me </label>
            </div>

        </ul>
    </form>

</body>
</html>