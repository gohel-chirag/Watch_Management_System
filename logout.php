<?php
    require_once "assets/includes/config.php";

    session_unset();
    session_destroy();

    header("Location: login.php");
    exit();
?>

