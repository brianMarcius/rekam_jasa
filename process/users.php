<?php
session_start();
include ('../config/conn.php');
include ('../config/function.php');

if(isset($_POST['tambah'])){
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $level = $_POST['level'];
    $password = password_hash($_POST['password'],PASSWORD_DEFAULT);

    $cek = mysqli_query($con,"SELECT * FROM user WHERE un='$username'") or die(mysqli_error($con));
    if(mysqli_num_rows($cek)==0){
        $insert = mysqli_query($con,"INSERT INTO user (nama, un, pw, lv) VALUES ('$nama','$username','$password','$level')") or die (mysqli_error($con));
        if($insert){
            $success = 'Berhasil menambahkan data pengguna';
        }else{
            $error = 'Gagal menambahkan data pengguna';
        }
    }else{
        $error = 'Username telah terdaftar !';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?pengguna');
}
if(isset($_POST['ubah'])){
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $password = $_POST['password'];
    $level = $_POST['level'];

    if($password!=""){
        $update = mysqli_query($con,"UPDATE user SET nama='$nama', lv='$level', pw='".password_hash($password,PASSWORD_DEFAULT)."' WHERE id='$id'") or die (mysqli_error($con));
    }else{
        $update = mysqli_query($con,"UPDATE user SET nama='$nama', lv='$level' WHERE id='$id'") or die (mysqli_error($con));
    }
    if($update){
        $success = 'Berhasil mengubah data pengguna';
    }else{
        $error = 'Gagal mengubah data pengguna';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?pengguna');
}

if(decrypt($_GET['act'])=='delete' && isset($_GET['id'])!=""){
    $id = decrypt($_GET['id']);
    $delete = mysqli_query($con, "DELETE FROM user WHERE id='$id'")or die(mysqli_error($con));
    if ($delete) {
        $success = "Data pengguna berhasil dihapus";
    }else{
        $error = "Data pengguna gagal dihapus";
    }
    $_SESSION['success'] = $success;
    header('Location:../?pengguna');
}

if(decrypt($_GET['act'])=='ganti_pass' && isset($_POST['ubah_pass'])){
    $id = $_POST['id'];
    $password =password_hash($_POST['password'],PASSWORD_DEFAULT);

    $update = mysqli_query($con,"UPDATE user SET pw='$password' WHERE id='$id'") or die (mysqli_error($con));
    $_SESSION['success'] = "Anda berhasil mengubah password";
    echo '<script>window.history.back();</script>';
}

?>