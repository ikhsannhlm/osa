<?php
include "connect.php";

// Read ID from query string
if (!isset($_GET['id'])) {
    die("ID parameter is missing!");
}

$id = $_GET['id'];

// Delete data from scan_rfid table
$delete = mysqli_query($connect, "DELETE FROM scan_rfid WHERE ID='$id'");

if($delete) {
    echo "
        <script>
            alert('Data Deleted');
            location.replace('attendance.php'); // Redirect to recapitulation page
        </script>
    ";
} else {
    echo "
        <script>
            alert('Failed to delete data for ID: $id');
            location.replace('attendance.php'); // Redirect to recapitulation page
        </script>
    ";
}
?>
