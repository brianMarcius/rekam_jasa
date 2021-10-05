<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include ('../config/conn.php');
include ('../config/function.php');

if(isset($_POST['tambah'])){
    $jasa_id = $_POST['jenis_jasa'];
    $transaksi_no = $_POST['transaksi_no'];
    $transaksi_tgl = time();
    $transaksi_nama = $_POST['transaksi_nama'];
    $transaksi_jumlah = $_POST['transaksi_jumlah'];

    $harga = mysqli_fetch_array(mysqli_query($con,"SELECT jasa_harga FROM jasa WHERE idjasa=$jasa_id")) or die(mysqli_error($con));
    $transaksi_total = (int)$_POST['transaksi_jumlah'] * $harga['jasa_harga'];
    $pengguna_id = $_SESSION['iduser'];

    $cekNomor = mysqli_query($con,"SELECT * FROM transaksi WHERE transaksi_no='$transaksi_no'") or die(mysqli_error($con));
    if(mysqli_num_rows($cekNomor)==0){
        $insert = mysqli_query($con,"INSERT INTO transaksi (jasa_id, transaksi_no, transaksi_tgl, transaksi_nama, transaksi_jumlah, transaksi_total_harga, pengguna_id) VALUES ('$jasa_id','$transaksi_no','$transaksi_tgl','$transaksi_nama','$transaksi_jumlah','$transaksi_total','$pengguna_id')") or die (mysqli_error($con));
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
    header('Location:../?transaksi');
}

if(isset($_POST['ubah'])){
    $idtransaksi = $_POST['idtransaksi'];
    $jasa_id = $_POST['jenis_jasa'];
    $transaksi_no = $_POST['transaksi_no'];
    $transaksi_tgl = time();
    $transaksi_nama = $_POST['transaksi_nama'];
    $transaksi_jumlah = $_POST['transaksi_jumlah'];

    $harga = mysqli_fetch_array(mysqli_query($con,"SELECT jasa_harga FROM jasa WHERE idjasa=$jasa_id")) or die(mysqli_error($con));
    $transaksi_total = (int)$_POST['transaksi_jumlah'] * $harga['jasa_harga'];
    $pengguna_id = $_SESSION['iduser'];

    $update = mysqli_query($con,"UPDATE transaksi SET jasa_id='$jasa_id', transaksi_no='$transaksi_no', transaksi_nama='$transaksi_nama', transaksi_jumlah='$transaksi_jumlah', transaksi_total_harga='$transaksi_total', pengguna_id='$pengguna_id'  WHERE idtransaksi='$idtransaksi'") or die (mysqli_error($con));
    
    // var_dump($update);die;
    if($update){
        $success = 'Berhasil mengubah data transaksi';
    }else{
        $error = 'Gagal mengubah data transaksi';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?transaksi');
}

if(decrypt($_GET['act'])=='delete' && isset($_GET['id'])!=""){
    // echo $_GET['act'];die;
    $id = decrypt($_GET['id']);
    $delete = mysqli_query($con, "DELETE FROM transaksi WHERE idtransaksi='$id'")or die(mysqli_error($con));
    if ($delete) {
        $success = "Data transaksi berhasil dihapus";
    }else{
        $error = "Data transaksi gagal dihapus";
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?transaksi');
}
?>