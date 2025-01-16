<?php
    include "connect.php";

    $idcard = $_GET['idcard'];
    mysqli_query($connect, "delete from tmprfid");

    $save = mysqli_query($connect,"insert into tmprfid(IDCard)values('$idcard')");
    if($save)
        echo "Succes";
    else 
    echo "Failed";
?>