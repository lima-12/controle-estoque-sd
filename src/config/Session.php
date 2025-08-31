<?php

class Session {
    
    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public static function setUser($user) {
        self::start();
        $_SESSION['usuario'] = $user;
        $_SESSION['logged_in'] = true;
        $_SESSION['login_time'] = time();
    }
    
    public static function getUser() {
        self::start();
        return $_SESSION['usuario'] ?? null;
    }
    
    public static function isLoggedIn() {
        self::start();
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }
    
    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header('Location: ../../../index.php');
            exit;
        }
    }
    
    public static function destroy() {
        self::start();
        session_destroy();
        session_unset();
    }
    
    public static function logout() {
        self::destroy();
        header('Location: ../../index.php');
        exit;
    }
}
