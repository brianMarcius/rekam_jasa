<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include ('../config/conn.php');
include ('../config/function.php');

if(isset($_POST['tambah'])){
    $tipe_no = $_POST['tipe_no'];
    $namatipe = $_POST['namatipe'];
    $idcat = $_POST['idcat'];
    $idbrand = $_POST['idbrand'];


    $cekNomor = mysqli_query($con,"SELECT * FROM tipe WHERE tipe_no='$tipe_no'") or die(mysqli_error($con));
    if(mysqli_num_rows($cekNomor)==0){
        $insert = mysqli_query($con,"INSERT INTO tipe (data_status, tipe_no, namatipe, idcat, idbrand) VALUES ('Enable','$tipe_no','$namatipe','$idcat', '$idbrand')") or die (mysqli_error($con));
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
    header('Location:../?tipe');
}

if(isset($_POST['ubah'])){
    $tipe_no = $_POST['tipe_no'];
    $namatipe = $_POST['namatipe'];
    $idcat = $_POST['idcat'];
    $idbrand = $_POST['idbrand'];


    $update = mysqli_query($con,"UPDATE tipe SET namatipe='$namatipe', idcat='$idcat', idbrand='$idbrand' WHERE tipe_no='$tipe_no'") or die (mysqli_error($con));

    // var_dump($update);die;
    if($update){
        $success = 'Berhasil mengubah data transaksi';
    }else{
        $error = 'Gagal mengubah data transaksi';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?tipe');
}


if(decrypt($_GET['act'])=='delete' && isset($_GET['idtipe'])!=""){
    $idtipe = decrypt($_GET['idtipe']);
    $delete = mysqli_query($con, "UPDATE tipe SET data_status='Disable' WHERE idtipe='$idtipe'")or die(mysqli_error($con));
    if ($delete) {
        $success = "Data pengguna berhasil dihapus";
    }else{
        $error = "Data pengguna gagal dihapus";
    }
    $_SESSION['success'] = $success;
    header('Location:../?tipe');
}

?>