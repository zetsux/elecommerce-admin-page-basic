<?php 
    session_start();
    
    $_SESSION = [];
    session_unset();
    session_destroy();

    setcookie('log1', '', time() - 100);
    setcookie('log2', '', time() - 100);

    header('Location: login.php');
    exit;
?>