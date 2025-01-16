<?php
include "connect.php";

// Check if ID is present in the query string
if (!isset($_GET['id'])) {
    die("ID parameter is missing!");
}

$id = $_GET['id'];

// Delete the validation data by ID
$delete = mysqli_query($connect, "DELETE FROM validation WHERE id='$id'");

if ($delete) {
    echo "
        <script>
            alert('Data Deleted');
            location.replace('attendance.php'); // Redirect to attendance page after successful deletion
        </script>
    ";
} else {
    echo "
        <script>
            alert('Failed to delete data');
            location.replace('attendance.php'); // Redirect to attendance page in case of error
        </script>
    ";
}
?>
