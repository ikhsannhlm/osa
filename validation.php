<?php
function validate_scans($date, $time, $total_yolo_scan, $connect) {
    // Hitung total_rfid_scan berdasarkan date dan time
    $query = "SELECT COUNT(ID) AS total_rfid_scan FROM scan_rfid";
    $result = mysqli_query($connect, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $total_rfid_scan = $row['total_rfid_scan'];

        // Bandingkan total_rfid_scan dan total_yolo_scan
        $validation_status = ($total_rfid_scan == $total_yolo_scan) ? 'valid' : 'invalid';

        // Simpan hasil validasi ke tabel validation
        $insertQuery = "INSERT INTO validation (total_rfid_scan, total_yolo_scan, validation_date, validation_time, validation_status) 
                        VALUES ('$total_rfid_scan', '$total_yolo_scan', '$date', '$time', '$validation_status')";
        $insertResult = mysqli_query($connect, $insertQuery);

        if ($insertResult) {
            return [
                'status' => 'success',
                'validation_status' => $validation_status
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Failed to insert validation data: ' . mysqli_error($connect)
            ];
        }
    } else {
        return [
            'status' => 'error',
            'message' => 'No matching RFID data found for the given date and time'
        ];
    }
}
?>
