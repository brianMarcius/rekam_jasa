<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include ('../config/conn.php');
include ('../config/function.php');

if(isset($_POST['tambah'])){
    $id_sup = $_POST['id_sup'];
    $sup_name = $_POST['sup_name'];
    $sup_no = $_POST['sup_no'];
    $sup_addr = $_POST['sup_addr'];
    $sup_phn = $_POST['sup_phn'];


    $cekNomor = mysqli_query($con,"SELECT * FROM sup WHERE id_sup='$id_sup'") or die(mysqli_error($con));
    if(mysqli_num_rows($cekNomor)==0){
        $insert = mysqli_query($con,"INSERT INTO sup (id_sup, sup_name, sup_no, sup_addr, sup_phn) VALUES ('$id_sup','$sup_name','$sup_no','$sup_addr','$sup_phn')") or die (mysqli_error($con));
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
    header('Location:../?sup');
}

if(isset($_POST['ubah'])){
    $sup_name = $_POST['sup_name'];
    $sup_no = $_POST['sup_no'];
    $sup_addr = $_POST['sup_addr'];
    $sup_phn = $_POST['sup_phn'];

    $update = mysqli_query($con,"UPDATE sup SET sup_name='$sup_name', sup_addr='$sup_addr', sup_phn='$sup_phn' WHERE sup_no='$sup_no'") or die (mysqli_error($con));
    
    // var_dump($update);die;
    if($update){
        $success = 'Berhasil mengubah data transaksi';
    }else{
        $error = 'Gagal mengubah data transaksi';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?sup');
}



if(decrypt($_GET['act'])=='delete' && isset($_GET['id_sup'])!=""){
    // echo $_GET['act'];die;
    $id_sup = decrypt($_GET['id_sup']);
    $delete = mysqli_query($con, "UPDATE sup SET data_status='Disable' WHERE id_sup='$id_sup'")or die(mysqli_error($con));
    if ($delete) {
        $success = "Data transaksi berhasil dihapus";
    }else{
        $error = "Data transaksi gagal dihapus";
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?sup');
}
?>