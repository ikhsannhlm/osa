<?php
include 'connect.php';

// Check if ID is present in the query string
if (!isset($_GET['id'])) {
    die("ID parameter is missing!");
}

$id = $_GET['id'];

// Fetch validation data by ID
$search = mysqli_query($connect, "SELECT * FROM validation WHERE id='$id'");
if (mysqli_num_rows($search) == 0) {
    die("Validation data not found for ID: $id");
}

$result = mysqli_fetch_array($search);

if (isset($_POST['btnSave'])) {
    // Receive input from the form and ensure safety
    $total_yolo_scan = mysqli_real_escape_string($connect, $_POST['TotalYOLOScan']);
    $total_rfid_scan = $result['total_rfid_scan']; // Get total RFID scan from the current record

    // Check if total YOLO scan is equal to total RFID scan
    if ($total_yolo_scan == $total_rfid_scan) {
        // If they are equal, set validation status to 'valid'
        $validation_status = 'valid';
    } else {
        // Otherwise, leave validation status unchanged
        $validation_status = $result['validation_status'];
    }

    // Query to update the total YOLO scan data and validation status
    $save = mysqli_query($connect, "UPDATE validation SET total_yolo_scan='$total_yolo_scan', validation_status='$validation_status' WHERE id='$id'");

    if ($save) {
        echo "<script>
                alert('Data Saved');
                location.replace('attendance.php'); // Redirect back to attendance page
              </script>";
    } else {
        echo "<script>
                alert('Failed to update data');
                location.replace('attendance.php');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Validation Data</title>
    <?php include 'header.php'; ?> <!-- Include header -->
</head>
<body>

    <?php include 'navbar.php'; ?> <!-- Include navbar -->
    <?php include 'sidebar.php'; ?> <!-- Include sidebar -->

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Validation Data</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active">Edit Validation Data</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Validation Data</h3>
                    </div>
                    <form method="POST">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="Date">Date</label>
                                <input type="text" name="Date" id="Date" value="<?php echo $result['validation_date']; ?>" class="form-control" readonly>
                            </div>

                            <div class="form-group">
                                <label for="Time">Time</label>
                                <input type="text" name="Time" id="Time" value="<?php echo $result['validation_time']; ?>" class="form-control" readonly>
                            </div>

                            <div class="form-group">
                                <label for="TotalRFIDScan">Total RFID Scan</label>
                                <input type="text" name="TotalRFIDScan" id="TotalRFIDScan" value="<?php echo $result['total_rfid_scan']; ?>" class="form-control" readonly>
                            </div>

                            <div class="form-group">
                                <label for="TotalYOLOScan">Total YOLO Scan</label>
                                <input type="number" name="TotalYOLOScan" id="TotalYOLOScan" value="<?php echo $result['total_yolo_scan']; ?>" class="form-control" required>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" name="btnSave">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <?php include 'footer.php'; ?> <!-- Include footer -->

</body>
</html>
