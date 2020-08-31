<?php
    include("functions.php");
    secure_session_start();
    session_destroy();
    header("Location: login.php");
    exit();
?>