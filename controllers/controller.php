<?php
// dev_mode = 1
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require 'function.php';
$db_path='../databases/database.php';
$fe_path='../pages/';

// Menangani request untuk login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    require $db_path;
    $username_email = mysqli_real_escape_string($conn, $_POST['username_email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    login($username_email, $password, $role);
}

// Menangani request untuk menampilkan semua pengguna (Read)
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['getUsers'])) {
    checkAuth();  // Pastikan pengguna sudah login
    require $db_path;

    $users = getUsers();
    $_SESSION['users'] = $users;
    header('Location: user_list.php');  // Redirect untuk menampilkan daftar pengguna
    exit;
}

// Menangani request untuk menampilkan data pengguna berdasarkan ID (Read - by ID)
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['getUser'])) {
    checkAuth();  // Pastikan pengguna sudah login
    require $db_path;

    $user_id = mysqli_real_escape_string($conn, $_GET['getUser']);
    $user = getUserById($user_id);
    $_SESSION['user_to_edit'] = $user;
    header('Location: edit_user.php');  // Redirect untuk mengedit pengguna
    exit;
}

// Create User Request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['createUser'])) {
    require $db_path;

    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $username = strtolower($first_name . $last_name); // Convert to lowercase
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    $createResult = createUser($first_name, $last_name, $username, $password, $email, $role, $phone);

    if ($createResult === "success") {
        $_SESSION['success_message'] = "Pendaftaran berhasil! Silahkan login.";
        echo "<script>window.alert('Pendaftaran berhasil. Silahkan login.');</script>";
        header('Location: ' . $fe_path . 'index.php');
        exit();
    } else {
        $_SESSION['error_message'] = $createResult;
        header('Location: ' . $fe_path . 'register.php');
        exit();
    }
}

// Update login handling in controller.php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    require $db_path;
    $username_email = mysqli_real_escape_string($conn, $_POST['username_email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    
    $login_result = login($username_email, $password, $role);
    
    if ($login_result['status'] === 'success') {
        $_SESSION['login_success'] = $login_result['message'];
        header("Location: ../pages/dashboard.php");
    } else {
        $_SESSION['login_error'] = $login_result['message'];
        header("Location: ../pages/index.php");
    }
    exit();
}

// Update auth check in other endpoints
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['getUsers'])) {
    if (!checkAuth()) {
        $_SESSION['error_message'] = 'Please login first';
        header('Location: ../pages/index.php');
        exit();
    }
    require $db_path;

    $users = getUsers();
    $_SESSION['users'] = $users;
    header('Location: user_list.php');  // Redirect untuk menampilkan daftar pengguna
    exit;
}

// Update admin check in relevant endpoints
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateUser'])) {
    if (!checkAuth()) {
        $_SESSION['error_message'] = 'Please login first';
        header('Location: ../pages/index.php');
        exit();
    }
    if (!checkAdmin()) {
        $_SESSION['error_message'] = 'Admin access required';
        header('Location: ../pages/dashboard.php');
        exit();
    }
    require $db_path;

    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    
    // Jika password tidak diubah, bisa dilewati
    $password = isset($_POST['password']) ? mysqli_real_escape_string($conn, $_POST['password']) : '';

    if ($password) {
        $updateResult = updateUser($user_id, $username, $password, $email, $role);
    } else {
        $updateResult = updateUser($user_id, $username, null, $email, $role);
    }

    // Setelah berhasil atau gagal, arahkan kembali ke halaman yang sesuai
    if ($updateResult === "Pengguna berhasil diperbarui.") {
        $_SESSION['success_message'] = $updateResult;
        header('Location: user_list.php');
    } else {
        $_SESSION['error_message'] = $updateResult;
        header('Location: edit_user.php');
    }
}
// Menangani request untuk menghapus pengguna (Delete)
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['deleteUser'])) {
    checkAuth();  // Pastikan pengguna sudah login
    checkAdmin();  // Pastikan pengguna adalah admin
    require $db_path;

    $user_id = mysqli_real_escape_string($conn, $_GET['deleteUser']);
    $deleteResult = deleteUser($user_id);
    
    // Setelah penghapusan, redirect ke daftar pengguna
    if ($deleteResult === "Pengguna berhasil dihapus.") {
        $_SESSION['success_message'] = $deleteResult;
    } else {
        $_SESSION['error_message'] = $deleteResult;
    }
    header('Location: user_list.php');  // Redirect ke halaman daftar pengguna
    exit;
}

// Logout
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: ../index.html');
    exit;
}
