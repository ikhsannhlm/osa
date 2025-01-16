<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {
    include "connect.php";
    include "validation.php";

    date_default_timezone_set('Asia/Jakarta'); // Set timezone Asia/Jakarta
    $date = $_POST['date'];
    $time = $_POST['time'];
    $totalPeopleDetected = $_POST['total_people_detected'];

    // Simpan data ke database
    $sql = "INSERT INTO scan_yolo (date, time, total_people_detected) 
            VALUES ('$date', '$time', '$totalPeopleDetected')";
    $result = mysqli_query($connect, $sql);

    if ($result) {
        // Jalankan validasi setelah data disimpan
        $validationResult = validate_scans($date, $time, $totalPeopleDetected, $connect);
        $validationStatus = $validationResult['validation_status'];

        echo "<script>alert('Data saved successfully. Validation status: $validationStatus');</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($connect) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan YOLO</title>
    <?php include "header.php"; ?>
    <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
</head>
<body>
<?php include "navbar.php"; ?>
<?php include "sidebar.php"; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Scan YOLO</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Scan YOLO</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Card for Upload Image -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Upload Image for YOLO Scan</h3>
                        </div>
                        <div class="card-body">
                            <!-- Upload Form -->
                            <form action="upload_to_api.php" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="image">Select Image:</label>
                                    <input type="file" class="form-control" id="image" name="image" accept=".jpg,.jpeg,.png" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Upload and Scan</button>
                            </form>
                        </div>
                    </div>

                    <!-- Card for YOLO Scan Result -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">YOLO Scan Result</h3>
                        </div>
                        <div class="card-body">
                            <?php
                            if (isset($_GET['status']) && $_GET['status'] == 'success') {
                                date_default_timezone_set('Asia/Jakarta'); // Set timezone Asia/Jakarta
                                $imagePath = $_GET['image'];
                                $totalPeopleDetected = $_GET['total_people_detected'];
                                $currentDate = date('Y-m-d');
                                $currentTime = date('H:i:s');

                                echo "<h4>Total People Detected: $totalPeopleDetected</h4>";
                                echo "<img src='$imagePath' class='img-fluid' alt='YOLO Detection Result'>";
                                ?>
                                <form action="scan_yolo.php" method="POST" class="mt-3">
                                    <input type="hidden" name="date" value="<?php echo $currentDate; ?>">
                                    <input type="hidden" name="time" value="<?php echo $currentTime; ?>">
                                    <input type="hidden" name="total_people_detected" value="<?php echo $totalPeopleDetected; ?>">
                                    <button type="submit" name="save" class="btn btn-success">Save</button>
                                </form>
                                <?php
                            } else {
                                echo "<p>No scan result available. Please upload an image.</p>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include "footer.php"; ?>
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
