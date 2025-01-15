<?php
include 'header.php';
include 'navbar.php';
include 'sidebar.php';
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Student Data</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Student Data</li>
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
                    <!-- Card for Table -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Student Data</h3>
                        </div>
                        <div class="card-body">
                            <table id="studentTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr style="background-color: grey; color: white; text-align: center;">
                                        <th>No</th>
                                        <th>IDCard</th>
                                        <th>NIM</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Include koneksi database
                                    include 'connect.php';

                                    // Ambil data mahasiswa
                                    $sql = mysqli_query($connect, "SELECT * FROM student");
                                    $no = 0;
                                    while ($data = mysqli_fetch_array($sql)) {
                                        $no++;
                                        echo "
                                        <tr>
                                            <td style='text-align: center;'>$no</td>
                                            <td style='text-align: center;'>{$data['IDCard']}</td>
                                            <td style='text-align: center;'>{$data['NIM']}</td>
                                            <td>{$data['Name']}</td>
                                            <td style='text-align: center;'>
                                                <a class='btn btn-info btn-sm' href='edit_student.php?id={$data['ID']}'>
                                                    <i class='fas fa-pencil-alt'></i> Edit
                                                </a>
                                                <a class='btn btn-danger btn-sm' href='delete_student.php?id={$data['ID']}'>
                                                    <i class='fas fa-trash'></i> Delete
                                                </a>
                                            </td>
                                        </tr>";
                                    }
                                    ?>
                                </tbody>
                                <?php
                                    // Menghitung jumlah student
                                    $count_sql = mysqli_query($connect, "SELECT COUNT(*) AS total_student FROM student");
                                    $count_data = mysqli_fetch_assoc($count_sql);
                                    $total_student = $count_data['total_student'];
                                ?>
                                <!-- Tampilan Table -->
                                <tfoot>
                                    <tr style="background-color: grey; color: white; text-align: center;">
                                        <th>Total</th>
                                        <th colspan="4" style="text-align: left;">
                                            <?php echo $total_student; ?>
                                        </th>
                                    </tr>
                                </tfoot>

                            </table>
                            <!-- Tombol Add Student -->
                            <a href="add_student.php">
                                <button class="btn btn-primary mt-3">
                                    Add Student
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
    include 'footer.php';
?>        

<!-- DataTables & Plugins -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
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
    $(document).ready(function () {
        $("#studentTable").DataTable({
            responsive: true,
            lengthChange: true,
            autoWidth: false,
            buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
            language: {
                search: "Filter data:",
                paginate: {
                    previous: "Previous",
                    next: "Next"
                }
            }
        }).buttons().container().appendTo('#studentTable_wrapper .col-md-6:eq(0)');
    });
</script>
