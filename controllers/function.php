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

// Fungsi Read - Mendapatkan semua pengguna
function getUsersByRole($role) {
    require '../databases/database.php';
    $sql = "SELECT * FROM users WHERE role='$role'";
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
function updateUser($user_id, $first_name, $last_name, $username, $password, $email, $phone) {
    global $conn;

    // Check if a new password is provided, and hash it if so
    $hashedPassword = $password ? password_hash($password, PASSWORD_BCRYPT) : null;

    // Start building the SQL query
    $sql = "UPDATE users SET first_name = ?, last_name = ?, username = ?, email = ?, phone = ?";
    $params = [$first_name, $last_name, $username, $email, $phone];
    $types = "sssss";

    // Add password to SQL query if it is being updated
    if ($hashedPassword) {
        $sql .= ", password = ?";
        $params[] = $hashedPassword;
        $types .= "s";
    }

    // Finalize the query with the condition
    $sql .= " WHERE user_id = ?";
    $params[] = $user_id;
    $types .= "i";

    // Prepare and bind parameters dynamically
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);

    // Execute the query and return the result
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

// Validasi auth untuk input, update, dll
function checkInputAuth() {
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        $auth=false;
    }else{
        $auth=true;
    }
    return $auth;
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


// ======= DASHBOARD DATA ======
// Rows Counter 
// Fungsi Count Row - Menghitung jumlah baris dalam tabel tertentu
function countRowsUsersByRole($role) {
    require '../databases/database.php';
    $sql = "SELECT COUNT(*) AS total FROM users WHERE role='$role'";
    $result = $conn->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        return $row['total'];
    } else {
        return "Error: " . $conn->error;
    }
}

// Fungsi Count Row - Menghitung jumlah baris dalam tabel tertentu
function countWorkshops() {
    require '../databases/database.php';
    $sql = "SELECT COUNT(*) AS total FROM workshops";
    $result = $conn->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        return $row['total'];
    } else {
        return "Error: " . $conn->error;
    }
}

// Fungsi Read - Mendapatkan workshop populer
function getPopularWorkshop() {
    require '../databases/database.php';

    $sql = "
        SELECT 
            workshops.*, 
            COUNT(registrations.user_id) AS totalpendaftar
        FROM 
            workshops
        LEFT JOIN 
            registrations ON workshops.workshop_id = registrations.workshop_id
        GROUP BY 
            workshops.workshop_id
        ORDER BY 
            totalpendaftar DESC
        LIMIT 9
    ";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}



// Peserta bulanan
function getMonthlyParticipants() {
    require '../databases/database.php';
    $monthlyParticipants = [];

    for ($month = 1; $month <= 12; $month++) {
        $query = "SELECT COUNT(*) as total FROM users WHERE MONTH(created_at) = $month";
        $result = $conn->query($query);
        $data = $result->fetch_assoc();
        $monthlyParticipants[] = $data['total'];
    }

    return $monthlyParticipants;
}

// Fungsi untuk mengambil acara dari database
function getEvents() {
    require '../databases/database.php';
    
    $sql = "SELECT title, start_date AS start, end_date AS end FROM workshops WHERE status = 'active'";
    $result = $conn->query($sql);

    $events = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $events[] = [
                'title' => $row['title'],
                'start' => $row['start'],
                'end' => $row['end']
            ];
        }
    }

    return $events;
}

// Rekap Data Keuangan
function getFinancialData() {
    require '../databases/database.php';
    
    $sql = "SELECT 
            r.registration_id,
            CONCAT(u.first_name, ' ', u.last_name) as nama_peserta,
            w.title as nama_workshop,
            w.price as harga_workshop,
            p.amount as jumlah_bayar,
            p.payment_method as metode_pembayaran,
            p.payment_status as status_pembayaran,
            DATE_FORMAT(p.payment_date, '%d/%m/%Y') as tanggal_pembayaran,
            r.status as status_registrasi,
            CONCAT(m.first_name, ' ', m.last_name) as nama_mitra  -- Menambahkan nama mitra
            FROM registrations r
            LEFT JOIN payments p ON r.registration_id = p.registration_id
            LEFT JOIN users u ON r.user_id = u.user_id AND u.role = 'user'  -- Filter role untuk peserta
            LEFT JOIN workshops w ON r.workshop_id = w.workshop_id
            LEFT JOIN users m ON w.mitra_id = m.user_id AND m.role = 'mitra'  -- Join dengan pengguna yang memiliki role mitra
            WHERE u.role = 'user'";  // Pastikan hanya peserta yang diambil

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

// // Fungsi untuk menghitung total penghasilan
function countTotalEarnings() {
    require '../databases/database.php';

    // Query untuk menghitung total penghasilan dari pembayaran yang statusnya 'successful'
    $sql = "SELECT SUM(p.amount) as total_penghasilan
            FROM payments p
            WHERE p.payment_status = 'successful'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['total_penghasilan'];
    } else {
        return 0; // Jika tidak ada data, kembalikan 0
    }
}

// ========================================
//          LANDING PAGE FUNCTION
// ========================================
// Fetch Untuk Landing Page
function getWorkshopsWithMitra() {
    require '../databases/database.php';

    // Query untuk mengambil semua data workshop dan relasikan dengan data mitra yang memiliki role 'mitra'
    $query = "
        SELECT 
            w.workshop_id,
            w.title,
            w.description,
            w.banner,
            w.price,
            w.location,
            w.start_date,
            w.end_date,
            w.status,
            w.training_overview,
            w.trained_competencies,
            w.training_session,
            w.requirements,
            w.benefits,
            m.user_id AS mitra_id,
            m.first_name AS mitra_first_name,
            m.last_name AS mitra_last_name,
            m.email AS mitra_email,
            m.phone AS mitra_phone,
            DATEDIFF(w.end_date, w.start_date) + 1 AS duration_days
        FROM workshops w
        LEFT JOIN users m ON w.mitra_id = m.user_id
        WHERE m.role = 'mitra' AND w.status = 'active'
        ORDER BY w.created_at DESC
    ";

    // Eksekusi query
    $result = mysqli_query($conn, $query);

    // Mengecek apakah query berhasil
    if ($result) {
        $workshops = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $workshops;
    } else {
        return "Error fetching workshops: " . mysqli_error($conn);
    }
}
// ========================================
//          SESSION FUNCTION
// ========================================
function checkUserSession() {
    session_start();
    if(!isset($_SESSION['user_id'])) {
        return false;
    }
    return true;
}


// ========================================
//          WORKSHOP CRUD
// ========================================
function createWorkshop($mitra_id, $title, $description, $banner, $training_overview, $trained_competencies, 
                       $training_session, $requirements, $benefits, $price, $location, $start_date, $end_date, $status) {
    global $conn;

    $sql = "INSERT INTO workshops (mitra_id, title, description, banner, training_overview, 
            trained_competencies, training_session, requirements, benefits, price, location, 
            start_date, end_date, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssssssdssss", $mitra_id, $title, $description, $banner, 
                      $training_overview, $trained_competencies, $training_session, 
                      $requirements, $benefits, $price, $location, $start_date, $end_date, $status);

    if ($stmt->execute()) {
        return "Workshop berhasil dibuat.";
    }
    return "Gagal membuat workshop: " . $stmt->error;
}

function getAllWorkshops() {
    require '../databases/database.php';
    
    $sql = "SELECT w.*, CONCAT(u.first_name, ' ', u.last_name) as mitra_name 
            FROM workshops w 
            LEFT JOIN users u ON w.mitra_id = u.user_id 
            ORDER BY w.created_at DESC";
    
    $result = $conn->query($sql);
    return ($result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

function getWorkshopById($workshop_id) {
    require '../databases/database.php';
    
    $sql = "SELECT w.*, CONCAT(u.first_name, ' ', u.last_name) as mitra_name 
            FROM workshops w 
            LEFT JOIN users u ON w.mitra_id = u.user_id 
            WHERE w.workshop_id = ?";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $workshop_id);
    $stmt->execute();
    
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function updateWorkshop($workshop_id, $title, $description, $banner, $training_overview, 
                       $trained_competencies, $training_session, $requirements, $benefits, 
                       $price, $location, $start_date, $end_date, $status) {
    global $conn;

    $sql = "UPDATE workshops 
            SET title = ?, description = ?, banner = ?, training_overview = ?, 
                trained_competencies = ?, training_session = ?, requirements = ?, 
                benefits = ?, price = ?, location = ?, start_date = ?, 
                end_date = ?, status = ? 
            WHERE workshop_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssdsssi", $title, $description, $banner, $training_overview, 
                      $trained_competencies, $training_session, $requirements, $benefits, 
                      $price, $location, $start_date, $end_date, $status, $workshop_id);

    if ($stmt->execute()) {
        return "Workshop berhasil diperbarui.";
    }
    return "Gagal memperbarui workshop: " . $stmt->error;
}

function deleteWorkshop($workshop_id) {
    global $conn;
    
    $sql = "DELETE FROM workshops WHERE workshop_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $workshop_id);
    
    if ($stmt->execute()) {
        return "Workshop berhasil dihapus.";
    }
    return "Gagal menghapus workshop: " . $stmt->error;
}


?>
