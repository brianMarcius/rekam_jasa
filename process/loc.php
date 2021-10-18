<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include ('../config/conn.php');
include ('../config/function.php');

if(isset($_POST['tambah'])){
    $id_aloc = $_POST['id_aloc'];
    $aloc_name = $_POST['aloc_name'];
    $aloc_no = $_POST['aloc_no'];


    $cekNomor = mysqli_query($con,"SELECT * FROM asset_loc WHERE id_aloc='$id_aloc'") or die(mysqli_error($con));
    if(mysqli_num_rows($cekNomor)==0){
        $insert = mysqli_query($con,"INSERT INTO asset_loc (id_aloc, aloc_name, aloc_no) VALUES ('$id_aloc','$aloc_name','$aloc_no')") or die (mysqli_error($con));
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
    header('Location:../?loc');
}

if(isset($_POST['ubah'])){
    $aloc_name = $_POST['aloc_name'];
    $aloc_no = $_POST['aloc_no'];

    $update = mysqli_query($con,"UPDATE asset_loc SET aloc_name='$aloc_name' WHERE aloc_no='$aloc_no'") or die (mysqli_error($con));
    
    // var_dump($update);die;
    if($update){
        $success = 'Berhasil mengubah data transaksi';
    }else{
        $error = 'Gagal mengubah data transaksi';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?loc');
}



if(decrypt($_GET['act'])=='delete' && isset($_GET['id_aloc'])!=""){
    // echo $_GET['act'];die;
    $id_aloc = decrypt($_GET['id_aloc']);
    $delete = mysqli_query($con, "UPDATE asset_loc SET data_status='Disable' WHERE id_aloc='$id_aloc'")or die(mysqli_error($con));
    if ($delete) {
        $success = "Data transaksi berhasil dihapus";
    }else{
        $error = "Data transaksi gagal dihapus";
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?loc');
}
?>