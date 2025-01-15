<?php
include 'connect.php';

// Cek apakah ID ada di query string
if (!isset($_GET['id'])) {
    die("ID parameter is missing!");
}

$id = $_GET['id'];

// Mengambil data student berdasarkan ID
$search = mysqli_query($connect, "SELECT * FROM student WHERE ID='$id'");
if (mysqli_num_rows($search) == 0) {
    die("Student not found");
}

$result = mysqli_fetch_array($search);

if (isset($_POST['btnSave'])) {
    // Menerima input form dan memastikan data aman
    $idcard = mysqli_real_escape_string($connect, $_POST['IDCard']);
    $nim = mysqli_real_escape_string($connect, $_POST['NIM']);
    $name = mysqli_real_escape_string($connect, $_POST['Name']);

    // Query untuk update data
    $save = mysqli_query($connect, "UPDATE student SET IDCard='$idcard', NIM='$nim', Name='$name' WHERE ID='$id'");

    if ($save) {
        echo "<script>
                alert('Data Saved');
                location.replace('student_data.php');
              </script>";
    } else {
        echo "<script>
                alert('Failed to update data');
                location.replace('student_data.php');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Data</title>

    <?php include 'header.php'; ?> <!-- Include header -->

    <!-- Include any additional JS for IDCard automation -->
    <script type="text/javascript">
        $(document).ready(function(){
            setInterval(function(){
                $("#idcard").load('idcard.php');
            }, 0);
        });
    </script>
</head>
<body>

    <?php include 'navbar.php'; ?> <!-- Include navbar -->
    <?php include 'sidebar.php'; ?> <!-- Include sidebar -->

    <!-- Main content section -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active">Edit Student Data</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <!-- Card for form -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Student Data</h3>
                    </div>
                    <!-- Form starts -->
                    <form method="POST">
                        <div class="card-body">

                            <div class="form-group">
                                <label for="IDCard">IDCard</label>
                                <input type="text" name="IDCard" id="IDCard" value="<?php echo $result['IDCard']; ?>" class="form-control" style="width: 200px;" required>
                            </div>

                            <div class="form-group">
                                <label for="NIM">NIM</label>
                                <input type="text" name="NIM" id="NIM" value="<?php echo $result['NIM']; ?>" class="form-control" style="width: 200px;" required>
                            </div>

                            <div class="form-group">
                                <label for="Name">Name</label>
                                <input type="text" name="Name" id="Name" value="<?php echo $result['Name']; ?>" class="form-control" style="width: 400px;" required>
                            </div>
                        </div>
                        <!-- Card footer with submit button -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" name="btnSave" id="btnSave">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <?php include 'footer.php'; ?> <!-- Include footer -->

</body>
</html>
