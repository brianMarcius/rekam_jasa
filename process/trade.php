<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include ('../config/conn.php');
include ('../config/function.php');

if(isset($_POST['tambah'])){
    $tradeno = $_POST['tradeno'];
    $idcust = $_POST['idcust'];
    $paymentdate = $_POST['paymentdate'];
    $method = $_POST['method'];
    $idjasa = $_POST['idjasa'];
    $totaltrade = $_POST['totaltrade'];

    $harga = mysqli_fetch_array(mysqli_query($con,"SELECT biaya FROM jenis_jasa WHERE id_jasa=$idjasa")) or die(mysqli_error($con));
    $totalharga = (int)$_POST['totaltrade'] * $harga['biaya'];

    $cekNomor = mysqli_query($con,"SELECT * FROM trade WHERE tradeno='$tradeno'") or die(mysqli_error($con));
    if(mysqli_num_rows($cekNomor)==0){
        $insert = mysqli_query($con,"INSERT INTO trade (data_status, tradeno, idcust, paymentdate, method, idjasa, totaltrade, totalharga) VALUES
         ('Enable', '$tradeno','$idcust','$paymentdate', '$method', '$idjasa', '$totaltrade', '$totalharga'") or die (mysqli_error($con));
        $success = 'Berhasil mengubah data transaksi';
        //if($insert){
        //    $update1 = mysqli_query($con,"UPDATE customer SET exp=DATE_ADD(exp, interval '$totaltrade' MONTH) WHERE idcust='$idcust'") or die (mysqli_error($con));
        //   if($update1){
        //        $success = 'Berhasil mengubah data transaksi';
        //    }else{
        //        $error = 'Gagal mengubah data transaksi';
        //    }
    }else{
        $error = 'Nomor Transaksi telah digunakan !';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?trade');
}

if(isset($_POST['ubah'])){
    $tradeno = $_POST['tradeno'];
    $idcust = $_POST['idcust'];
    $paymentdate = $_POST['paymentdate'];
    $method = $_POST['method'];
    $idjasa = $_POST['idjasa'];
    $totaltrade = $_POST['totaltrade'];

    $harga = mysqli_fetch_array(mysqli_query($con,"SELECT biaya FROM jenis_jasa WHERE id_jasa=$idjasa")) or die(mysqli_error($con));
    $totalharga = (int)$_POST['totaltrade'] * $harga['biaya'];

    $update = mysqli_query($con,"UPDATE 
    trade SET idcust='$idcust', paymentdate='$paymentdate', method='$method', idjasa='$idjasa', totaltrade='$totaltrade', totalharga='$totalharga'   
    WHERE tradeno='$tradeno'") or die (mysqli_error($con));
    $success = 'Berhasil mengubah data transaksi';

    // var_dump($update);die;
    //if($update){
    //    $update1 = mysqli_query($con,"UPDATE customer SET exp=DATE_ADD(exp, interval '$totaltrade' MONTH) WHERE idcust='$idcust'") or die (mysqli_error($con));
    //    if($update1){
    //        $success = 'Berhasil mengubah data transaksi';
    //    }else{
    //       $error = 'Gagal mengubah data transaksi';
    //    }
    }else{
        $error = 'Gagal mengubah data transaksi';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?trade');
}


if(decrypt($_GET['act'])=='delete' && isset($_GET['idtrade'])!=""){
    // echo $_GET['act'];die;
    $idtrade = decrypt($_GET['idtrade']);
    $delete = mysqli_query($con, "UPDATE trade SET data_status='Disable' WHERE idtrade='$idtrade'")or die(mysqli_error($con));
    if ($delete) {
        $success = "Data transaksi berhasil dihapus";
    }else{
        $error = "Data transaksi gagal dihapus";
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?trade');
}
?>