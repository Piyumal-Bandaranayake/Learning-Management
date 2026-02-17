<?php
session_start();

/**
 * Check if user is logged in
 */
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

/**
 * Check if user is an admin
 */
function is_admin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

/**
 * Redirect if not logged in
 */
function require_login() {
    if (!is_logged_in()) {
        header("Location: /Learning-Mangment/login.php");
        exit;
    }
}

/**
 * Redirect if not admin
 */
function require_admin() {
    require_login();
    if (!is_admin()) {
        header("Location: /Learning-Mangment/student/dashboard.php");
        exit;
    }
}
?>
