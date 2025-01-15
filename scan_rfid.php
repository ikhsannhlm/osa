<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan RFID</title>
    <?php include 'header.php'; ?> <!-- Include header -->
    <!--Scanning RFID Card-->
    <script type="text/javascript">
        $(document).ready(function() {
            setInterval(function() {
                $("#checkcard").load('read_rfid.php')
            }, 2000);
        });
    </script>
</head>
<body>

<?php include 'navbar.php'; ?> <!-- Include navbar -->
<?php include 'sidebar.php'; ?> <!-- Include sidebar -->

<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Scan RFID</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Scan RFID Card</h3>
            </div>
            <div id="checkcard"></div>
        </div>
    </section>
</div>

<?php include 'footer.php'; ?> <!-- Include footer -->

</body>
</html>
