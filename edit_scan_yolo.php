<?php
include 'connect.php';

// Cek apakah ID ada di query string
if (!isset($_GET['id'])) {
    die("ID parameter is missing!");
}

$id = $_GET['id'];

// Mengambil data scan_yolo berdasarkan ID
$search = mysqli_query($connect, "SELECT * FROM scan_yolo WHERE ID='$id'");
if (mysqli_num_rows($search) == 0) {
    die("Scan data not found for ID: $id");
}

$result = mysqli_fetch_array($search);

if (isset($_POST['btnSave'])) {
    // Menerima input form dan memastikan data aman
    $date = mysqli_real_escape_string($connect, $_POST['Date']);
    $time = mysqli_real_escape_string($connect, $_POST['Time']);
    $total_people_detected = mysqli_real_escape_string($connect, $_POST['TotalPeopleDetected']);

    // Query untuk update data scan_yolo
    $save = mysqli_query($connect, "UPDATE scan_yolo SET date='$date', time='$time', total_people_detected='$total_people_detected' WHERE ID='$id'");

    if ($save) {
        echo "<script>
                alert('Data Saved');
                location.replace('attendance.php'); // Redirect ke halaman attend.php setelah berhasil
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
    <title>Edit Scan YOLO Data</title>
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
                        <h1>Edit Scan YOLO Data</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active">Edit Scan YOLO Data</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Scan YOLO Data</h3>
                    </div>
                    <form method="POST">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="Date">Date</label>
                                <input type="date" name="Date" id="Date" value="<?php echo $result['date']; ?>" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="Time">Time</label>
                                <input type="time" name="Time" id="Time" value="<?php echo $result['time']; ?>" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="TotalPeopleDetected">Total People Detected</label>
                                <input type="number" name="TotalPeopleDetected" id="TotalPeopleDetected" value="<?php echo $result['total_people_detected']; ?>" class="form-control" required>
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
