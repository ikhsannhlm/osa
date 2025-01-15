<?php 
include "connect.php";

$sql = mysqli_query($connect, "select * from tmprfid");
$data = mysqli_fetch_array($sql);

// Periksa apakah $data tidak null
if ($data) {
    $idcard = $data['IDCard'];
} else {
    $idcard = ""; // Atur idcard menjadi string kosong jika tidak ada data
}
?>

<div class="form-group">
    <label>IDCard</label>
    <input type="text" name="IDCard" id="IDCard" placeholder="Put your IDCard on the reader" 
        class="form-control" style="width: 200px;" value="<?php echo htmlspecialchars($idcard); ?>">
</div>
