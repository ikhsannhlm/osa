<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan YOLO</title>
    <?php include "header.php"; ?> <!-- Include header -->
    <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
</head>
<body>

<?php include "navbar.php"; ?> <!-- Include navbar -->
<?php include "sidebar.php"; ?> <!-- Include sidebar -->

<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header -->
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

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Card for Upload Image -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Upload Image for YOLO Scan</h3>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <!-- Upload Form -->
                            <form action="upload_to_api.php" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="image">Select Image:</label>
                                    <input type="file" class="form-control" id="image" name="image" accept=".jpg,.jpeg,.png" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Upload and Scan</button>
                            </form>

                            <?php
                            if (isset($_GET['status']) && $_GET['status'] == 'success') {
                                $imagePath = $_GET['image'];
                                $totalPeopleDetected = $_GET['total_people_detected'];
                                echo "<hr>";
                                echo "<h4>Total People Detected: $totalPeopleDetected</h4>";
                                echo "<img src='$imagePath' class='img-fluid' alt='YOLO Detection Result'>";
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include "footer.php"; ?> <!-- Include footer -->

<!-- Scripts -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
