<?php
session_start();
include ('../config/conn.php');

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $query = mysqli_query($con,"SELECT * FROM asset a, category c, brand b, tipe t, sup s WHERE a.idcat=c.idcat and a.idbrand=b.idbrand 
    and a.idtipe=t.idtipe and a.id_sup=s.id_sup and a.id_asset='$id'") or die(mysqli_error($con));
    $data = mysqli_fetch_array($query);
    echo json_encode($data);
}
?>