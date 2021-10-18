<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include ('../config/conn.php');
include ('../config/function.php');

if(isset($_POST['tambah'])){
    $idcust = $_POST['idcust'];
    $nama = $_POST['nama'];
    $addr = $_POST['addr'];
    $phn = $_POST['phn'];
    $nik = $_POST['nik'];
    $ins = $_POST['ins'];
    $cust_no = $_POST['cust_no'];
    $exp = $_POST['exp'];
    $id_type = $_POST['id_type'];
    $id_jasa = $_POST['id_jasa'];
    $status = $_POST['status'];

    $cekNomor = mysqli_query($con,"SELECT * FROM customer WHERE cust_no='$cust_no'") or die(mysqli_error($con));
    if(mysqli_num_rows($cekNomor)==0){
        $insert = mysqli_query($con,"INSERT INTO customer (cust_no, nama, addr, phn, nik, ins, exp, id_type, status, id_jasa)
         VALUES ('$cust_no','$nama','$addr','$phn','$nik','$ins','$exp','$id_type','$status','$id_jasa')") or die (mysqli_error($con));
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
    header('Location:../?listcust');
}

if(isset($_POST['ubah'])){
    $idcust = $_POST['idcust'];
    $namacust = $_POST['nama'];
    $addrcust = $_POST['addr'];
    $phncust = $_POST['phn'];
    $nikcust = $_POST['nik'];
    $cust_no = $_POST['cust_no'];
    $inscust = $_POST['ins'];
    $expcust = $_POST['exp'];
    $id_type = $_POST['id_type'];
    $id_jasa = $_POST['id_jasa'];
    $status = $_POST['status'];

    $update = mysqli_query($con,"UPDATE customer SET cust_no='$cust_no', nama='$namacust', addr='$addrcust', phn='$phncust', 
    ins='$inscust', exp='$expcust', nik='$nikcust',id_type='$id_type',status='$status', id_jasa='$id_jasa' WHERE idcust='$idcust'") or die (mysqli_error($con));

    // var_dump($update);die;
    if($update){
        $success = 'Berhasil mengubah data transaksi';
    }else{
        $error = 'Gagal mengubah data transaksi';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?listcust');
}

if(isset($_POST['ubahsoon'])){
    $idcust = $_POST['idcust'];
    $expcust = $_POST['exp'];
    $renew = $_POST['renew'];

    $update = mysqli_query($con,"UPDATE customer SET exp=DATE_ADD(exp, interval '$renew' MONTH) WHERE idcust='$idcust'") or die (mysqli_error($con));;

    // var_dump($update);die;
    if($update){
        $success = 'Berhasil mengubah data transaksi';
    }else{
        $error = 'Gagal mengubah data transaksi';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?soon');
}

if(isset($_POST['ubahexp'])){
    $idcust = $_POST['idcust'];
    $expcust = $_POST['exp'];
    $renew = $_POST['renew'];

    $update = mysqli_query($con,"UPDATE customer SET exp=DATE_ADD(exp, interval '$renew' MONTH) WHERE idcust='$idcust'") or die (mysqli_error($con));

    // var_dump($update);die;
    if($update){
        $success = 'Berhasil mengubah data transaksi';
    }else{
        $error = 'Gagal mengubah data transaksi';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?expired');
}

if(decrypt($_GET['act'])=='delete' && isset($_GET['idcust'])!=""){
    // echo $_GET['act'];die;
    $idcust = decrypt($_GET['idcust']);
    $delete = mysqli_query($con, "UPDATE customer SET data_status='Disable' WHERE idcust='$idcust'")or die(mysqli_error($con));
    if ($delete) {
        $success = "Data transaksi berhasil dihapus";
    }else{
        $error = "Data transaksi gagal dihapus";
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?listcust');
}
?>