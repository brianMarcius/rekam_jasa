<?php
    if(isset($_GET['backup_app'])){
        include ('proses/backup_app.php');
    }
    else if(isset($_GET['backup_db'])){
        include ('proses/backup_db.php');
    }
    else if(isset($_GET['jenis_jasa'])){
        $master = $jenis_jasa = true;
        $views = 'views/master/jenis_jasa.php';
    }
    else if(isset($_GET['listcust'])){
        $cust = $listcust = true;
        $views = 'views/cust/listcust.php';
    }
    else if(isset($_GET['soon'])){
        $cust = $soon = true;
        $views = 'views/cust/soon.php';
    }
    else if(isset($_GET['expired'])){
        $cust = $expired = true;
        $views = 'views/cust/expired.php';
    }
    else if(isset($_GET['asset'])){
        $prod = $asset = true;
        $views = 'views/produk/asset.php';
    }
    else if(isset($_GET['cat'])){
        $prod = $cat = true;
        $views = 'views/produk/cat.php';
    }
    else if(isset($_GET['brand'])){
        $prod = $brand = true;
        $views = 'views/produk/brand.php';
    }
    else if(isset($_GET['tipe'])){
        $prod = $tipe = true;
        $views = 'views/produk/tipe.php';
    }
    else if(isset($_GET['loc'])){
        $prod = $loc = true;
        $views = 'views/produk/loc.php';
    }
    else if(isset($_GET['sup'])){
        $prod = $sup = true;
        $views = 'views/produk/sup.php';
    }
    else if(isset($_GET['pengguna'])){
        $master = $pengguna = true;
        $views = 'views/master/pengguna.php';
    }
    else if(isset($_GET['transaksi'])){
        $transaksi = true;
        $views = 'views/transaksi.php';
    }
    else if(isset($_GET['laporan'])){
        $laporan = true;
        $views = 'views/laporan.php';
    }
    else{
        $home = true;
        $views = 'views/listcust`.php';
    }
?>