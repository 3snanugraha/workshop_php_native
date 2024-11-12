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
    if($_SESSION['role']!='admin'){
        $role = mysqli_real_escape_string($conn, $_POST['role']);
    }else{
        $role = 'user';
    }
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    $createResult = createUser($first_name, $last_name, $username, $password, $email, $role, $phone);

    if(!isset($_SESSION['user_id'])){
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
    }else{
        echo "<script>alert('Peserta berhasil ditambahkan');window.location='../pages/data-peserta.php';</script>";
    }
}

// Create User Request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['createMitra'])) {
    require $db_path;

    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $username = strtolower($first_name . $last_name); // Convert to lowercase
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    if($_SESSION['role']!='admin'){
        $role = mysqli_real_escape_string($conn, $_POST['role']);
    }else{
        $role = 'mitra';
    }
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    $createResult = createUser($first_name, $last_name, $username, $password, $email, $role, $phone);

    if(!isset($_SESSION['user_id'])){
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
    }else{
        echo "<script>alert('Mitra berhasil ditambahkan');window.location='../pages/data-mitra.php';</script>";
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
    $auth = checkInputAuth();
    if (!$auth) {
        echo "<script>alert('Anda tidak diizinkan untuk operasi ini.');window.location='../pages/index.php';</script>";
        exit();
    } else {
        require $db_path;

        $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);

        // Check if a new password is provided; if empty, pass null
        $password = !empty($_POST['password']) ? mysqli_real_escape_string($conn, $_POST['password']) : null;

        // Update the user with the provided data
        $updateResult = updateUser($user_id, $first_name, $last_name, $username, $password, $email, $phone);

        // Redirect after updating
        if ($updateResult === "Pengguna berhasil diperbarui.") {
            echo "<script>alert('$updateResult');</script>";
            echo "<script>window.location.href='../pages/data-peserta.php';</script>";
        } else {
            echo "<script>alert('$updateResult');</script>";
            echo "<script>window.location.href='../pages/data-peserta.php';</script>";
        }
    }
}

// Update admin check in relevant endpoints
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateMitra'])) {
    $auth = checkInputAuth();
    if (!$auth) {
        echo "<script>alert('Anda tidak diizinkan untuk operasi ini.');window.location='../pages/index.php';</script>";
        exit();
    } else {
        require $db_path;

        $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);

        // Check if a new password is provided; if empty, pass null
        $password = !empty($_POST['password']) ? mysqli_real_escape_string($conn, $_POST['password']) : null;

        // Update the user with the provided data
        $updateResult = updateUser($user_id, $first_name, $last_name, $username, $password, $email, $phone);

        // Redirect after updating
        if ($updateResult === "Pengguna berhasil diperbarui.") {
            echo "<script>alert('Mitra berhasil diperbarui.');</script>";
            echo "<script>window.location.href='../pages/data-mitra.php';</script>";
        } else {
            echo "<script>alert('Mitra gagal diperbarui.');</script>";
            echo "<script>window.location.href='../pages/data-mitra.php';</script>";
        }
    }
}



// Menangani request untuk menghapus pengguna (Delete)
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['deleteUser'])) {
    $auth = checkInputAuth();
    if (!$auth) {
        echo "<script>alert('Anda tidak diizinkan untuk operasi ini.');window.location='../pages/index.php';</script>";
        exit();
        }else{
            require $db_path;

            $user_id = mysqli_real_escape_string($conn, $_GET['deleteUser']);
            $deleteResult = deleteUser($user_id);
            
            // Setelah penghapusan, redirect ke daftar pengguna
            if ($deleteResult === "Pengguna berhasil dihapus.") {
                echo "<script>alert('$deleteResult');</script>";
            } else {
                echo "<script>alert('$deleteResult');</script>";
            }
            echo "<script>window.location.href='../pages/data-peserta.php';</script>";    
            exit;
        }
}

// Logout
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: ../index.html');
    exit;
}
