<?php 
 
 class SessionHelper {
    // Kiểm tra nếu người dùng đã đăng nhập
    public static function isLoggedIn() {
        return isset($_SESSION['username']) && !empty($_SESSION['username']);
    }

    // Kiểm tra nếu người dùng là admin
    public static function isAdmin() {
        return isset($_SESSION['role']) && $_SESSION['role'] == 'admin';
    }

    // Kiểm tra nếu người dùng là user
    public static function isUser() {
        return isset($_SESSION['role']) && $_SESSION['role'] == 'user';
    }
}

