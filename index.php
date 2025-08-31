<?php
    require_once __DIR__ . '/src/config/Session.php';
    
    // Se já estiver logado, redireciona para home
    if (Session::isLoggedIn()) {
        header('Location: src/views/home.php');
    } else {
        header('Location: src/views/login.php');
    }
    exit();
?>
