<?php
// dev_mode
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

function createUser($first_name, $last_name, $username, $password, $email, $role) {
    require $db_path;
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Updated SQL query to include first_name and last_name
    $sql = "INSERT INTO users (first_name, last_name, username, password, email, role) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $first_name, $last_name, $username, $hashedPassword, $email, $role);

    if ($stmt->execute()) {
        return "Pengguna berhasil ditambahkan.";
    } else {
        return "Gagal menambahkan pengguna: " . $stmt->error;
    }
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

// Menangani request untuk memperbarui data pengguna (Update)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateUser'])) {
    checkAuth();  // Pastikan pengguna sudah login
    checkAdmin();  // Pastikan pengguna adalah admin
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


?>
