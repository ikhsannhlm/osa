<?php
include 'connect.php';

// Cek apakah ID ada di query string
if (!isset($_GET['id'])) {
    die("ID parameter is missing!");
}

$id = $_GET['id'];

// Mengambil data scan_rfid berdasarkan ID
$search = mysqli_query($connect, "SELECT * FROM scan_rfid WHERE ID='$id'");
if (mysqli_num_rows($search) == 0) {
    die("Scan data not found for ID: $id");
}

$result = mysqli_fetch_array($search);

if (isset($_POST['btnSave'])) {
    // Menerima input form dan memastikan data aman
    $idcard = mysqli_real_escape_string($connect, $_POST['IDCard']);
    $date = mysqli_real_escape_string($connect, $_POST['Date']);
    $time = mysqli_real_escape_string($connect, $_POST['Time']);

    // Query untuk update data scan_rfid
    $save = mysqli_query($connect, "UPDATE scan_rfid SET IDCard='$idcard', Date='$date', Time='$time' WHERE ID='$id'");

    if ($save) {
        echo "<script>
                alert('Data Saved');
                location.replace('attendance.php'); // Redirect ke halaman recapitulation setelah berhasil
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
    <title>Edit Scan RFID Data</title>
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
                        <h1>Edit Scan RFID Data</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active">Edit Scan RFID Data</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Scan RFID Data</h3>
                    </div>
                    <form method="POST">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="IDCard">IDCard</label>
                                <input type="text" name="IDCard" id="IDCard" value="<?php echo $result['IDCard']; ?>" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="Date">Date</label>
                                <input type="date" name="Date" id="Date" value="<?php echo $result['Date']; ?>" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="Time">Time</label>
                                <input type="time" name="Time" id="Time" value="<?php echo $result['Time']; ?>" class="form-control" required>
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
