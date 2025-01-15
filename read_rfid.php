<?php 
include "connect.php";

// Read table tmprfid
$readrfid = mysqli_query($connect, "select * from tmprfid");
$datarfid = mysqli_fetch_array($readrfid);

// Periksa apakah $datarfid tidak null
if ($datarfid) {
    $idcard = $datarfid['IDCard'];
} else {
    $idcard = ""; // Atur idcard menjadi string kosong jika tidak ada data
}
?>

<div class="container-fluid" style="text-align: center;">
    <?php 
    if ($idcard == "") { ?>
        <h3>Please Put Your Card on the Reader</h3>
        <img src="images/rfid_signal.png" style="width: 200px;"> <br>
        <img src="images/animasi2.gif" style="width: 200px;">
    <?php 
    } else {
        // Check if the card is registered
        $search_student = mysqli_query($connect, "select * from student where IDCard='$idcard'");
        $sumdata = mysqli_num_rows($search_student);

        if ($sumdata == 0) {
            echo "<h1>Sorry! Your card isn't registered</h1>";
        } else {
            $studentdata = mysqli_fetch_array($search_student);
            $name = $studentdata['Name'];

            date_default_timezone_set('Asia/Jakarta');
            $date = date('Y-m-d');
            $time = date('H:i:s');

            // Check if the card has already been registered today
            $search_attend = mysqli_query($connect, "select * from scan_rfid where IDCard='$idcard' and Date='$date'");

            // Count the data
            $sum_attend = mysqli_num_rows($search_attend);
            if ($sum_attend == 0) {
                echo "<h1>Welcome, $name :)</h1>";
                $insert_query = "INSERT INTO scan_rfid (IDCard, Date, Time) VALUES ('$idcard', '$date', '$time')";
                if (mysqli_query($connect, $insert_query)) {
                    echo "<h2>Attendance recorded successfully!</h2>";
                } else {
                    echo "<h2>Error: " . mysqli_error($connect) . "</h2>";
                }
            } else {
                echo "<h1>You have already checked in today, $name :)</h1>";
            }
        }
        // Empty the tmprfid table
        mysqli_query($connect, "DELETE FROM tmprfid");
    } 
    ?>
</div>
