<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include ('../config/conn.php');
include ('../config/function.php');

if(isset($_POST['tambah'])){
    $id_asset = $_POST['id_asset'];
    $idcat = $_POST['idcat'];
    $idbrand = $_POST['idbrand'];
    $id_aloc = $_POST['id_aloc'];
    $id_sup = $_POST['id_sup'];
    $idtipe = $_POST['idtipe'];
    $asset_no = $_POST['asset_no'];
    $nama_asset = $_POST['nama_asset'];
    $sn = $_POST['sn'];
    $pd = $_POST['pd'];
    $harga = $_POST['harga'];
    $status = $_POST['status'];
    $descr = $_POST['descr'];

    $cekNomor = mysqli_query($con,"SELECT * FROM asset WHERE id_asset='$id_asset'") or die(mysqli_error($con));
    if(mysqli_num_rows($cekNomor)==0){
        $insert = mysqli_query($con,"INSERT INTO asset (data_status, id_asset, idcat, idbrand, id_aloc, id_sup, idtipe, asset_no, nama_asset, sn, pd, harga, status, descr) 
        VALUES ('Enable','$id_asset','$idcat','$idbrand','$id_aloc','$id_sup','$idtipe','$asset_no','$nama_asset','$sn','$pd','$harga','$status','$descr')") or die (mysqli_error($con));
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
    header('Location:../?asset');
}

if(isset($_POST['ubah'])){
    $idcat = $_POST['idcat'];
    $idbrand = $_POST['idbrand'];
    $id_aloc = $_POST['id_aloc'];
    $id_sup = $_POST['id_sup'];
    $idtipe = $_POST['idtipe'];
    $asset_no = $_POST['asset_no'];
    $nama_asset = $_POST['nama_asset'];
    $sn = $_POST['sn'];
    $pd = $_POST['pd'];
    $harga = $_POST['harga'];
    $status = $_POST['status'];
    $descr = $_POST['descr'];

    $update = mysqli_query($con,"UPDATE asset SET idbrand='$idbrand', id_aloc='$id_aloc', id_sup='$id_sup', idtipe='$idtipe', 
    asset_no='$asset_no', nama_asset='$nama_asset', sn='$sn', pd='$pd', harga='$harga', status='$status', descr='$descr' WHERE idcat='$idcat'")
     or die (mysqli_error($con));
    
    // var_dump($update);die;
    if($update){
        $success = 'Berhasil mengubah data transaksi';
    }else{
        $error = 'Gagal mengubah data transaksi';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?asset');
}



if(decrypt($_GET['act'])=='delete' && isset($_GET['id_asset'])!=""){
    // echo $_GET['act'];die;
    $id_asset = decrypt($_GET['id_asset']);
    $delete = mysqli_query($con, "UPDATE asset SET data_status='Disable' WHERE id_asset='$id_asset'")or die(mysqli_error($con));
    if ($delete) {
        $success = "Data transaksi berhasil dihapus";
    }else{
        $error = "Data transaksi gagal dihapus";
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?asset');
}
?>