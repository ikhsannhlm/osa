<?php
    include "connect.php";

    //read ID
    $id = $_GET['id'];

    //read data
    $delete = mysqli_query($connect, "delete from student where ID='$id'");


    //If Success show message succes and back to Student Data Page
    if($delete)
        {
            echo "
                <script>
                    alert('Data Deleted');
                    location.replace('student_data.php');
                </script>
            ";
        }else
        {
            echo "
                <script>
                    alert('Failed deleted data');
                    location.replace('student_data.php');
                </script>
            ";
        }
    

?>