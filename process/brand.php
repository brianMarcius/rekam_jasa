<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include ('../config/conn.php');
include ('../config/function.php');

if(isset($_POST['tambah'])){
    $brand_no = $_POST['brand_no'];
    $namabrand = $_POST['namabrand'];
    $idcat = $_POST['idcat'];


    $cekNomor = mysqli_query($con,"SELECT * FROM brand WHERE brand_no='$brand_no'") or die(mysqli_error($con));
    if(mysqli_num_rows($cekNomor)==0){
        $insert = mysqli_query($con,"INSERT INTO brand (data_status, brand_no, namabrand, idcat) VALUES ('Enable', '$brand_no','$namabrand','$idcat')") or die (mysqli_error($con));
        if($insert){
            $success = 'Berhasil menambahkan data transaksi';
        }else{
            $error = 'Gagal menambahkan data transaksi';
        }
    }else{
        $error = 'Nomor Transaksi telah digunakan !';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?brand');
}

if(isset($_POST['ubah'])){
    $brand_no = $_POST['brand_no'];
    $namabrand = $_POST['namabrand'];
    $idcat = $_POST['idcat'];


    $update = mysqli_query($con,"UPDATE brand SET namabrand='$namabrand', idcat='$idcat' WHERE brand_no='$brand_no'") or die (mysqli_error($con));

    // var_dump($update);die;
    if($update){
        $success = 'Berhasil mengubah data transaksi';
    }else{
        $error = 'Gagal mengubah data transaksi';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?brand');
}


if(decrypt($_GET['act'])=='delete' && isset($_GET['idbrand'])!=""){
    // echo $_GET['act'];die;
    $idbrand = decrypt($_GET['idbrand']);
    $delete = mysqli_query($con, "UPDATE brand SET data_status='Disable' WHERE idbrand='$idbrand'")or die(mysqli_error($con));
    if ($delete) {
        $success = "Data transaksi berhasil dihapus";
    }else{
        $error = "Data transaksi gagal dihapus";
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?brand');
}
?>