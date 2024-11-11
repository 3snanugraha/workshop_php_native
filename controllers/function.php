<?php
// dev_mode
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Fungsi Create - Menambahkan pengguna baru
function createUser($first_name, $last_name, $username, $password, $email, $role, $phone) {
    global $conn;
    
    // Check if email already exists
    $check_email = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($check_email);
    if($result && $result->num_rows > 0) {
        return "Email sudah terdaftar.";
    }
    
    // Check if username already exists and generate new username if needed
    $original_username = $username;
    $counter = 1;
    
    do {
        $check_username = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($check_username);
        if($result && $result->num_rows > 0) {
            $username = $original_username . $counter;
            $counter++;
        } else {
            break;
        }
    } while(true);

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
    // Direct query without prepare
    $sql = "INSERT INTO users (first_name, last_name, username, password, email, role, phone) 
            VALUES ('$first_name', '$last_name', '$username', '$hashedPassword', '$email', '$role', '$phone')";
            
    if ($conn->query($sql)) {
        return "success";
    } else {
        return "Gagal menambahkan pengguna: " . $conn->error;
    }
}

// Fungsi Read - Mendapatkan semua pengguna
function getUsers() {
    require '../databases/database.php';
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
    $username_email = mysqli_real_escape_string($conn, $username_email);
    $password = mysqli_real_escape_string($conn, $password);
    $role = mysqli_real_escape_string($conn, $role);

    $query = "SELECT * FROM users WHERE (email = '$username_email' OR username = '$username_email') AND role = '$role'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            return ['status' => 'success', 'message' => 'Login successful'];
        }
        return ['status' => 'error', 'message' => 'Incorrect password'];
    }
    return ['status' => 'error', 'message' => 'No user found with this username/email and role'];
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
