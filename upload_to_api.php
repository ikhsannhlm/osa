<?php
include 'connect.php'; // Koneksi ke database
include 'validation.php'; // Tambahkan validasi ke dalam aplikasi

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['image'])) {
        $image = $_FILES['image'];

        // Pastikan file diunggah tanpa error
        if ($image['error'] === UPLOAD_ERR_OK) {
            $fileType = mime_content_type($image['tmp_name']);
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

            // Validasi tipe file
            if (in_array($fileType, $allowedTypes)) {
                $filePath = $image['tmp_name'];

                // URL API Anda
                $apiUrl = "http://127.0.0.1:8000/predict"; // Ganti dengan URL API Anda

                // Kirim file ke API
                $curl = curl_init();
                $cfile = curl_file_create($filePath, $fileType, $image['name']);
                $data = array('file' => $cfile);

                curl_setopt($curl, CURLOPT_URL, $apiUrl);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_HEADER, true); // Dapatkan headers dan body

                $response = curl_exec($curl);
                $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

                // Pisahkan header dan body
                $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
                $headers = substr($response, 0, $headerSize);
                $body = substr($response, $headerSize);

                curl_close($curl);

                if ($httpCode == 200) {
                    // Parse header untuk mendapatkan Total-People-Detected
                    $headersArray = [];
                    foreach (explode("\r\n", $headers) as $headerLine) {
                        if (strpos($headerLine, ":") !== false) {
                            list($key, $value) = explode(":", $headerLine, 2);
                            $headersArray[trim($key)] = trim($value);
                        }
                    }

                    // Ambil total_people_detected dari header API
                    $totalPeopleDetected = $headersArray['total-people-detected'] ?? 0;

                    // Cek apakah folder 'uploads' ada, jika tidak, buat folder
                    $uploadDir = 'uploads/';
                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir, 0777, true); // Membuat folder jika belum ada
                    }

                    // Simpan gambar hasil dari API
                    $outputImage = $uploadDir . 'output_' . time() . '.jpg';
                    file_put_contents($outputImage, $body);

                    // Menyimpan data ke database
                    date_default_timezone_set('Asia/Jakarta'); // Set timezone
                    $currentDate = date('Y-m-d');
                    $currentTime = date('H:i:s');

                    // Menyiapkan query untuk insert data ke tabel scan_yolo
                    $sql = "INSERT INTO scan_yolo (date, time, total_people_detected) 
                            VALUES ('$currentDate', '$currentTime', '$totalPeopleDetected')";
                    $result = mysqli_query($connect, $sql);

                    if ($result) {
                        // Panggil fungsi validasi setelah data berhasil disimpan ke tabel scan_yolo
                        $validationResult = validate_scans($currentDate, $currentTime, $totalPeopleDetected, $connect);
                        if ($validationResult['status'] == 'success') {
                            $validationStatus = $validationResult['validation_status'];

                            // Redirect dengan informasi validasi
                            header("Location: scan_yolo.php?status=success&image=$outputImage&total_people_detected=$totalPeopleDetected&validation_status=$validationStatus");
                        } else {
                            echo "Validation Error: " . $validationResult['message'];
                        }
                    } else {
                        echo "Error: " . mysqli_error($connect);
                    }
                    exit;
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to process image']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Only JPG, JPEG, PNG files are allowed']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error uploading file']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No file uploaded']);
    }
}
?>
