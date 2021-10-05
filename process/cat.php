<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include ('../config/conn.php');
include ('../config/function.php');

if(isset($_POST['tambah'])){
    $idcat = $_POST['idcat'];
    $namacat = $_POST['namacat'];
    $cat_no = $_POST['cat_no'];


    $cekNomor = mysqli_query($con,"SELECT * FROM category WHERE idcat='$idcat'") or die(mysqli_error($con));
    if(mysqli_num_rows($cekNomor)==0){
        $insert = mysqli_query($con,"INSERT INTO category (idcat, namacat, cat_no) VALUES ('$idcat','$namacat','$cat_no')") or die (mysqli_error($con));
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
    header('Location:../?cat');
}

if(isset($_POST['ubah'])){
    $nama_cat = $_POST['namacat'];
    $cat_no = $_POST['cat_no'];

    $update = mysqli_query($con,"UPDATE category SET namacat='$nama_cat' WHERE cat_no='$cat_no'") or die (mysqli_error($con));
    
    // var_dump($update);die;
    if($update){
        $success = 'Berhasil mengubah data transaksi';
    }else{
        $error = 'Gagal mengubah data transaksi';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?cat');
}



if(decrypt($_GET['act'])=='delete' && isset($_GET['idcat'])!=""){
    // echo $_GET['act'];die;
    $idcat = decrypt($_GET['idcat']);
    $delete = mysqli_query($con, "DELETE FROM category WHERE idcat='$idcat'")or die(mysqli_error($con));
    if ($delete) {
        $success = "Data transaksi berhasil dihapus";
    }else{
        $error = "Data transaksi gagal dihapus";
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?cat');
}
?>