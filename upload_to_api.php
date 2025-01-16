<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['image'])) {
        $image = $_FILES['image'];

        if ($image['error'] === UPLOAD_ERR_OK) {
            $fileType = mime_content_type($image['tmp_name']);
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

            if (in_array($fileType, $allowedTypes)) {
                $filePath = $image['tmp_name'];
                $apiUrl = "http://127.0.0.1:8000/predict"; 

                // Kirim file ke API
                $curl = curl_init();
                $cfile = curl_file_create($filePath, $fileType, $image['name']);
                $data = array('file' => $cfile);

                curl_setopt($curl, CURLOPT_URL, $apiUrl);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_HEADER, true);

                $response = curl_exec($curl);
                $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

                // Pisahkan header dan body
                $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
                $headers = substr($response, 0, $headerSize);
                $body = substr($response, $headerSize);

                curl_close($curl);

                if ($httpCode == 200) {
                    $headersArray = [];
                    foreach (explode("\r\n", $headers) as $headerLine) {
                        if (strpos($headerLine, ":") !== false) {
                            list($key, $value) = explode(":", $headerLine, 2);
                            $headersArray[trim($key)] = trim($value);
                        }
                    }

                    $totalPeopleDetected = $headersArray['total-people-detected'] ?? 0;
                    $uploadDir = 'uploads/';
                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    $outputImage = $uploadDir . 'output_' . time() . '.jpg';
                    file_put_contents($outputImage, $body);

                    header("Location: scan_yolo.php?status=success&image=$outputImage&total_people_detected=$totalPeopleDetected");
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
