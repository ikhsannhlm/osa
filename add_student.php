<?php
include 'connect.php';

if (isset($_POST['btnSave'])) {
    // Membaca data input form
    $idcard = $_POST['IDCard'];
    $nim = $_POST['NIM'];
    $name = $_POST['Name'];

    // Menyimpan data ke tabel student
    $save = mysqli_query($connect, "INSERT INTO student (IDCard, NIM, Name) VALUES ('$idcard', '$nim', '$name')");

    // Jika berhasil, tampilkan pesan dan kembali ke halaman student data
    if ($save) {
        echo "
            <script>
                alert('Data Saved');
                location.replace('student_data.php');
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Failed to add data');
                location.replace('student_data.php');
            </script>
        ";
    }

    // Menghapus data di tabel tmprfid setelah penyimpanan
    mysqli_query($connect, "DELETE FROM tmprfid");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student Data</title>

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
                            <li class="breadcrumb-item active">Add Student Data</li>
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
                        <h3 class="card-title">Add Student Data</h3>
                    </div>
                    <!-- Form starts -->
                    <form method="POST">
                        <div class="card-body">
                            <!-- Display IDCard from external script -->
                            <div id="idcard"></div>

                            <div class="form-group">
                                <label for="NIM">NIM</label>
                                <input type="text" name="NIM" id="NIM" placeholder="Enter NIM" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="Name">Name</label>
                                <input type="text" name="Name" id="Name" placeholder="Enter Name" class="form-control" required>
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
