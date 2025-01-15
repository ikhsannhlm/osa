<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Recapitulation</title>
    <?php include "header.php"; ?> <!-- Include header -->
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
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
                    <h1>Recapitulation & Validation</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Recapitulation & Validation</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Card for Attendance Recap -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Recapitulation RFID Attender</h3>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <table id="attendanceTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr style="background-color: grey; color: white; text-align: center;">
                                        <th>No</th>
                                        <th>NIM</th>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    include "connect.php";

                                    date_default_timezone_set('Asia/Jakarta');
                                    $date = date('Y-m-d');

                                    // Fetch attendance data
                                    $sql = mysqli_query($connect, 
                                        "SELECT b.Name, b.NIM, a.Date, a.Time 
                                         FROM scan_rfid a, student b 
                                         WHERE a.IDCard = b.IDCard AND a.Date = '$date'");
                                    
                                    $no = 0;
                                    while ($data = mysqli_fetch_array($sql)) {
                                        $no++;
                                    ?>
                                    <tr style="text-align: center;">
                                        <td> <?php echo $no; ?> </td>
                                        <td> <?php echo $data['NIM']; ?> </td>
                                        <td> <?php echo $data['Name']; ?> </td>
                                        <td> <?php echo $data['Date']; ?> </td>
                                        <td> <?php echo $data['Time']; ?> </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <?php
                                    // Menghitung jumlah attendance pada hari ini
                                    $count_sql = mysqli_query($connect, 
                                        "SELECT COUNT(*) AS total_attender 
                                        FROM scan_rfid a, student b 
                                        WHERE a.IDCard = b.IDCard AND a.Date = '$date'");
                                    $count_data = mysqli_fetch_assoc($count_sql);
                                    $total_attender = $count_data['total_attender'];
                                ?>
                                <!-- Tampilan Table -->
                                <tfoot>
                                    <tr style="background-color: grey; color: white; text-align: center;">
                                        <th>Total</th>
                                        <th colspan="4" style="text-align: left;">
                                            <?php echo $total_attender; ?>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- Card for YOLO Scan Recap -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Scan YOLO Recapitulation</h3>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <table id="scanYoloTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr style="background-color: grey; color: white; text-align: center;">
                                        <th>No</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Total People Detected</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    include "connect.php";

                                    // Fetch YOLO scan data
                                    $sql = mysqli_query($connect, "SELECT * FROM scan_yolo");

                                    $no = 0;
                                    while ($data = mysqli_fetch_array($sql)) {
                                        $no++;
                                    ?>
                                    <tr style="text-align: center;">
                                        <td> <?php echo $no; ?> </td>
                                        <td> <?php echo $data['date']; ?> </td>
                                        <td> <?php echo $data['time']; ?> </td>
                                        <td> <?php echo $data['total_people_detected']; ?> </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr style="background-color: grey; color: white; text-align: center;">
                                        <th>Total</th>
                                        <th colspan="3" style="text-align: left;">
                                            <?php
                                            // Count the total number of scans
                                            $count_sql = mysqli_query($connect, "SELECT COUNT(*) AS total_scans FROM scan_yolo");
                                            $count_data = mysqli_fetch_assoc($count_sql);
                                            echo $count_data['total_scans'];
                                            ?>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- Card for Validation -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Validation of RFID and YOLO Scan</h3>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <table id="validationTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr style="background-color: grey; color: white; text-align: center;">
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Total RFID Scan</th>
                                        <th>Total YOLO Scan</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    include "connect.php";

                                    // Fetch data from validation table
                                    $sql = mysqli_query($connect, 
                                        "SELECT validation_date AS date, validation_time AS time, 
                                                total_rfid_scan, total_yolo_scan, validation_status 
                                        FROM validation");

                                    while ($data = mysqli_fetch_array($sql)) {
                                        $statusClass = ($data['validation_status'] == 'valid') ? 'valid' : 'invalid';
                                    ?>
                                    <tr class="<?php echo $statusClass; ?>" style="text-align: center;">
                                        <td> <?php echo $data['date']; ?> </td>
                                        <td> <?php echo $data['time']; ?> </td>
                                        <td> <?php echo $data['total_rfid_scan']; ?> </td>
                                        <td> <?php echo $data['total_yolo_scan']; ?> </td>
                                        <td> 
                                            <span style="color: <?php echo ($data['validation_status'] == 'valid') ? 'green' : 'red'; ?>;">
                                                <?php echo ucfirst($data['validation_status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="edit_validation.php?date=<?php echo $data['date']; ?>&time=<?php echo $data['time']; ?>" class="btn btn-warning">Edit</a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr style="background-color: grey; color: white; text-align: center;">
                                        <th colspan="5">Total Entries</th>
                                        <th>
                                            <?php 
                                            $totalEntries = mysqli_num_rows($sql);
                                            echo $totalEntries; 
                                            ?> Entries
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include "footer.php"; ?> <!-- Include footer -->

<!-- Scripts -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script>
  $(function () {
    // Initialize DataTable
    $("#attendanceTable").DataTable({
      responsive: true,
      lengthChange: true,
      autoWidth: false,
      buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
      language: {
        search: "Filter data:",
        paginate: {
          previous: "Previous",
          next: "Next"
        },
      }
    }).buttons().container().appendTo('#attendanceTable_wrapper .col-md-6:eq(0)');
  });
</script>

<script>
  $(function () {
    // Initialize DataTable
    $("#scanYoloTable").DataTable({
      responsive: true,
      lengthChange: true,
      autoWidth: false,
      buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
      language: {
        search: "Filter data:",
        paginate: {
          previous: "Previous",
          next: "Next"
        },
      }
    }).buttons().container().appendTo('#scanYoloTable_wrapper .col-md-6:eq(0)');
  });
</script>

<script>
  $(function () {
    $("#validationTable").DataTable({
      responsive: true,
      lengthChange: true,
      autoWidth: false,
      buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
      language: {
        search: "Filter data:",
        paginate: {
          previous: "Previous",
          next: "Next"
        },
      }
    }).buttons().container().appendTo('#validationTable_wrapper .col-md-6:eq(0)');
  });
</script>

</body>
</html>
