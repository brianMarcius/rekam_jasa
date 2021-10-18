<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include ('../config/conn.php');
include ('../config/function.php');

if(isset($_POST['tambah'])){
    $id_jasa = $_POST['id_jasa'];
    $nama_jasa = $_POST['nama_jasa'];
    $jasa_no = $_POST['jasa_no'];
    $rincian = $_POST['rincian'];
    $biaya = $_POST['biaya'];


    $cekNomor = mysqli_query($con,"SELECT * FROM jenis_jasa WHERE id_jasa='$id_jasa'") or die(mysqli_error($con));
    if(mysqli_num_rows($cekNomor)==0){
        $insert = mysqli_query($con,"INSERT INTO jenis_jasa (id_jasa, nama_jasa, jasa_no, rincian, biaya) VALUES ('$id_jasa','$nama_jasa','$jasa_no','$rincian','$biaya')") or die (mysqli_error($con));
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
    header('Location:../?jj');
}

if(isset($_POST['ubah'])){
    $nama_jasa = $_POST['nama_jasa'];
    $jasa_no = $_POST['jasa_no'];
    $rincian = $_POST['rincian'];
    $biaya = $_POST['biaya'];

    $update = mysqli_query($con,"UPDATE jenis_jasa SET nama_jasa='$nama_jasa', biaya='$biaya', rincian='$rincian'  WHERE jasa_no='$jasa_no'") or die (mysqli_error($con));
    
    // var_dump($update);die;
    if($update){
        $success = 'Berhasil mengubah data transaksi';
    }else{
        $error = 'Gagal mengubah data transaksi';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?jj');
}



if(decrypt($_GET['act'])=='delete' && isset($_GET['id_jasa'])!=""){
    // echo $_GET['act'];die;
    $id_jasa = decrypt($_GET['id_jasa']);
    $delete = mysqli_query($con, "UPDATE jenis_jasa SET data_status='Disable' WHERE id_jasa='$id_jasa'")or die(mysqli_error($con));
    if ($delete) {
        $success = "Data transaksi berhasil dihapus";
    }else{
        $error = "Data transaksi gagal dihapus";
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?jj');
}
?>