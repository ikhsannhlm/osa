<?php
include 'connect.php';
include 'validation.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $totalPeopleDetected = intval($_POST['total_people_detected']);
    
    // Set waktu dan tanggal
    date_default_timezone_set('Asia/Jakarta');
    $currentDate = date('Y-m-d');
    $currentTime = date('H:i:s');

    // Simpan data ke tabel scan_yolo
    $sql = "INSERT INTO scan_yolo (date, time, total_people_detected) 
            VALUES ('$currentDate', '$currentTime', '$totalPeopleDetected')";
    $result = mysqli_query($connect, $sql);

    if ($result) {
        // Jalankan validasi setelah data disimpan
        $validationResult = validate_scans($currentDate, $currentTime, $totalPeopleDetected, $connect);
        if ($validationResult['status'] == 'success') {
            $validationStatus = $validationResult['validation_status'];
            header("Location: scan_yolo.php?status=success&message=Data saved successfully&validation_status=$validationStatus");
        } else {
            echo "Validation Error: " . $validationResult['message'];
        }
    } else {
        echo "Error: " . mysqli_error($connect);
    }
}
?>
