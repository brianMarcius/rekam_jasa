<?php
session_start();
include ('config/conn.php');
include ('../config/function.php');
//proses tambah
if(isset($_POST['tambah'])){
    $jasa_nama = $_POST['jasa_nama'];
    $jasa_harga = delMask($_POST['jasa_harga']);

    
    $insert = mysqli_query($con,"INSERT INTO jasa (jasa_nama, jasa_harga) VALUES ('$jasa_nama','$jasa_harga')") or die (mysqli_error($con));
    if($insert){
        $success = 'Berhasil menambahkan data jasa';
    }else{
        $error = 'Gagal menambahkan data jasa';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?jenis_jasa');
}
//proses hapus
if(decrypt($_GET['act'])=='delete' && isset($_GET['id'])!=""){
    $id = decrypt($_GET['id']);
    $query = mysqli_query($con, "DELETE FROM jasa WHERE idjasa='$id'")or die(mysqli_error($con));
    if($query){
        $success = 'Berhasil menghapus data jasa';
    }else{
        $error = 'Gagal menghapus data jasa';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?jenis_jasa');
}

?>