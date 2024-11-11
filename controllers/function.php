<?php
// dev_mode
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Fungsi Create - Menambahkan pengguna baru
function createUser($username, $password, $email, $role) {
    // Hash password untuk keamanan
    global $conn;
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Query SQL untuk insert data
    $sql = "INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $hashedPassword, $email, $role);

    if ($stmt->execute()) {
        return "Pengguna berhasil ditambahkan.";
    } else {
        return "Gagal menambahkan pengguna: " . $stmt->error;
    }
}

// Fungsi Read - Mendapatkan semua pengguna
function getUsers() {
    global $conn;
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

// Fungsi Read - Mendapatkan satu pengguna berdasarkan ID
function getUserById($user_id) {
    global $conn;
    $sql = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_assoc();
}

// Fungsi Update - Memperbarui data pengguna berdasarkan ID
function updateUser($user_id, $username, $password, $email, $role) {
    global $conn;
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $sql = "UPDATE users SET username = ?, password = ?, email = ?, role = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $username, $hashedPassword, $email, $role, $user_id);

    if ($stmt->execute()) {
        return "Pengguna berhasil diperbarui.";
    } else {
        return "Gagal memperbarui pengguna: " . $stmt->error;
    }
}

// Fungsi Delete - Menghapus pengguna berdasarkan ID
function deleteUser($user_id) {
    global $conn;
    $sql = "DELETE FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        return "Pengguna berhasil dihapus.";
    } else {
        return "Gagal menghapus pengguna: " . $stmt->error;
    }
}

// Fungsi untuk login
function login($username_email, $password, $role) {
    global $conn;
    // Menghindari SQL Injection
    $username_email = mysqli_real_escape_string($conn, $username_email);
    $password = mysqli_real_escape_string($conn, $password);
    $role = mysqli_real_escape_string($conn, $role);

    // Query untuk mencari pengguna berdasarkan username atau email dan role
    $query = "SELECT * FROM users WHERE (email = '$username_email' OR username = '$username_email') AND role = '$role'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Pengguna ditemukan, ambil data pengguna
        $user = mysqli_fetch_assoc($result);

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Simpan informasi login di session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role']; // Simpan role pengguna di session

            // Login berhasil
            $_SESSION['login_success'] = "Login successful.";
            header("Location: ../pages/dashboard.php"); 
            // Redirect ke halaman utama setelah login
            exit();
        } else {
            // Password salah
            $_SESSION['login_error'] = "Incorrect password.";
            header("Location: ../pages/index.php");
            exit();
        }
    } else {
        // Pengguna tidak ditemukan dengan username/email dan role yang diberikan
        $_SESSION['login_error'] = "No user found with this username/email and role.";
        header("Location: ../pages/index.php");
        exit();
    }
}

// Validasi sesi: Pastikan pengguna sudah login
function checkAuth() {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('Sesi anda telah habis. Silahkan login terlebih dahulu.');window.location='../pages/index.php';</script>";
        exit;
    }
}

// Validasi ketika di halaman login
function checkAuthorized(){
    session_start();
    if (isset($_SESSION['user_id'])) {
        echo "<script>alert('Anda sudah login. Akan diarahkan ke dashboard.');window.location='dashboard.php';</script>";
    }
}
// Validasi peran admin untuk beberapa aksi (hanya admin yang bisa menambah, mengubah, atau menghapus pengguna)
function checkAdmin() {
    session_start();
    if ($_SESSION['role'] !== 'admin') {
        $_SESSION['error_message'] = "Akses ditolak. Hanya admin yang dapat melakukan aksi ini.";
        header('Location: dashboard.php');
        exit;
    }
}

?>
