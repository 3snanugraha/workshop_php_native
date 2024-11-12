<?php
require 'function.php';
checkAuth();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kategori = $_POST['kategori'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $format = $_POST['format'];
    $is_preview = isset($_POST['preview']);

    switch($kategori) {
        case 'peserta':
            $query = "SELECT first_name, last_name, username, email, phone, created_at 
                     FROM users 
                     WHERE role = 'user' 
                     AND created_at BETWEEN '$start_date' AND '$end_date'";
            $headers = ['Nama Depan', 'Nama Belakang', 'Username', 'Email', 'No. Telepon', 'Tanggal Registrasi'];
            break;
            
        case 'mitra':
            $query = "SELECT first_name, last_name, username, email, phone, created_at 
                     FROM users 
                     WHERE role = 'mitra' 
                     AND created_at BETWEEN '$start_date' AND '$end_date'";
            $headers = ['Nama Depan', 'Nama Belakang', 'Username', 'Email', 'No. Telepon', 'Tanggal Registrasi'];
            break;
    }

    if (isset($_POST['sort_by'])) {
        $sort_field = $_POST['sort_by'];
        $query .= " ORDER BY $sort_field";
    }

    require '../databases/database.php';
    $result = $conn->query($query);
    $data = $result->fetch_all(MYSQLI_ASSOC);

    if ($is_preview) {
        echo generatePreviewTable($headers, $data);
    } else {
        switch($format) {
            case 'excel':
                exportExcel($headers, $data, $kategori);
                break;
            case 'csv':
                exportCSV($headers, $data, $kategori);
                break;
        }
    }
}

function generatePreviewTable($headers, $data) {
    $html = "<thead><tr>";
    foreach ($headers as $header) {
        $html .= "<th>$header</th>";
    }
    $html .= "</tr></thead><tbody>";

    foreach ($data as $row) {
        $html .= "<tr>";
        foreach ($row as $cell) {
            $html .= "<td>$cell</td>";
        }
        $html .= "</tr>";
    }
    
    $html .= "</tbody>";
    return $html;
}

function exportExcel($headers, $data, $kategori) {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Laporan_' . $kategori . '_' . date('Y-m-d') . '.xls"');
    header('Cache-Control: max-age=0');
    
    echo "<table border='1'>";
    
    // Headers
    echo "<tr>";
    foreach ($headers as $header) {
        echo "<th style='background-color: #ccc;'>" . $header . "</th>";
    }
    echo "</tr>";
    
    // Data
    foreach ($data as $row) {
        echo "<tr>";
        foreach ($row as $cell) {
            echo "<td>" . $cell . "</td>";
        }
        echo "</tr>";
    }
    
    echo "</table>";
    exit;
}

function exportCSV($headers, $data, $kategori) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="Laporan_' . $kategori . '_' . date('Y-m-d') . '.csv"');
    
    $output = fopen('php://output', 'w');
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
    
    fputcsv($output, $headers);
    foreach ($data as $row) {
        fputcsv($output, $row);
    }
    
    fclose($output);
    exit;
}
