<?php
session_start();
include ('../config/conn.php');

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $query = mysqli_query($con,"SELECT * FROM customer WHERE idcust='$id'") or die(mysqli_error($con));
    $data = mysqli_fetch_array($query);
    echo json_encode($data);
}
?>