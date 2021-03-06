<?php

if (!empty($_POST['func'])) {
    $func = $_POST['func'];
    $data = (!empty($_POST['data'])) ? $_POST['data'] : '' ;
    switch ($func) {
        case 'list_brand2':
            list_brand2($data);
            break;
        case 'list_tipe':
            list_tipe($data);
            break;
        case 'list_cust1':
            list_cust1($data);
            break;
        case 'getInstallation':
            getInstallation();
            break;
        default:
            //function not found, error or something
            break;
    }
}

function getInstallation(){
    include ('conn.php');

    $tahun = date('Y');
    $sql = "SELECT count(idcust) customer, date_format(ins,'%c') bulan FROM `customer` group by date_format(ins,'%c')";
    $query = mysqli_query($con,$sql);
    $data = array();
    while ($d = mysqli_fetch_array($query)) {
        $fetch = array();
        $fetch['bulan'] = $d['bulan'];
        $fetch['customer'] = $d['customer'];
        $data[] = $fetch;
    }

    echo json_encode($data);
}


function session_timeout(){
    //lama waktu 30 menit = 1800
    if(isset($_SESSION['LAST_ACTIVITY'])&&(time()-$_SESSION['LAST_ACTIVITY']>3600)){
        session_unset();
        session_destroy();
        header("Location:".$base_url."login.php");
    }$_SESSION['LAST_ACTIVITY']=time();
}
function delMask( $str ) {
    return (int)implode('',explode('.',$str));
}
function hakAkses( array $a){
    $akses = $_SESSION['level'];
    if(!in_array($akses,$a)){
        // header('Location:?');
        echo '<script>window.location = "?#";</script>';
    }
}
function noCustomer(){
    include ('conn.php');
    // mencari kode barang dengan nilai paling besar
    $query = "SELECT MAX(cust_no) as maxKode FROM customer";
    $hasil = mysqli_query($con,$query);
    $data = mysqli_fetch_array($hasil);
    $kodeBarang = $data['maxKode'];

    // mengambil angka atau bilangan dalam kode anggota terbesar,
    // dengan cara mengambil substring mulai dari karakter ke-1 diambil 6 karakter
    // misal 'TRX00001', akan diambil '001'
    // setelah substring bilangan diambil lantas dicasting menjadi integer
    $noUrut = (int) substr($kodeBarang, 4, 5);

    // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
    $noUrut++;

    // membentuk kode anggota baru
    // perintah sprintf("%03s", $noUrut); digunakan untuk memformat string sebanyak 3 karakter
    // misal sprintf("%03s", 12); maka akan dihasilkan '012'
    // atau misal sprintf("%03s", 1); maka akan dihasilkan string '001'
    $char = "CUST";
    $kodeBarang = $char . sprintf("%05s", $noUrut);
    return $kodeBarang;
}

function noJJ(){
    include ('conn.php');
    // mencari kode barang dengan nilai paling besar
    $query = "SELECT MAX(jasa_no) as maxKode FROM jenis_jasa";
    $hasil = mysqli_query($con,$query);
    $data = mysqli_fetch_array($hasil);
    $kodeBarang = $data['maxKode'];

    // mengambil angka atau bilangan dalam kode anggota terbesar,
    // dengan cara mengambil substring mulai dari karakter ke-1 diambil 6 karakter
    // misal 'TRX00001', akan diambil '001'
    // setelah substring bilangan diambil lantas dicasting menjadi integer
    $noUrut = (int) substr($kodeBarang, 4, 5);

    // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
    $noUrut++;

    // membentuk kode anggota baru
    // perintah sprintf("%03s", $noUrut); digunakan untuk memformat string sebanyak 3 karakter
    // misal sprintf("%03s", 12); maka akan dihasilkan '012'
    // atau misal sprintf("%03s", 1); maka akan dihasilkan string '001'
    $char = "JASA";
    $kodeBarang = $char . sprintf("%05s", $noUrut);
    return $kodeBarang;
}

function noCategory(){
    include ('conn.php');
    // mencari kode barang dengan nilai paling besar
    $query = "SELECT MAX(cat_no) as maxKode FROM category";
    $hasil = mysqli_query($con,$query);
    $data = mysqli_fetch_array($hasil);
    $kodeBarang = $data['maxKode'];

    // mengambil angka atau bilangan dalam kode anggota terbesar,
    // dengan cara mengambil substring mulai dari karakter ke-1 diambil 6 karakter
    // misal 'TRX00001', akan diambil '001'
    // setelah substring bilangan diambil lantas dicasting menjadi integer
    $noUrut = (int) substr($kodeBarang, 3, 5);

    // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
    $noUrut++;

    // membentuk kode anggota baru
    // perintah sprintf("%03s", $noUrut); digunakan untuk memformat string sebanyak 3 karakter
    // misal sprintf("%03s", 12); maka akan dihasilkan '012'
    // atau misal sprintf("%03s", 1); maka akan dihasilkan string '001'
    $char = "CAT";
    $kodeBarang = $char . sprintf("%05s", $noUrut);
    return $kodeBarang;
}

function noBrand(){
    include ('conn.php');
    // mencari kode barang dengan nilai paling besar
    $query = "SELECT MAX(brand_no) as maxKode FROM brand";
    $hasil = mysqli_query($con,$query);
    $data = mysqli_fetch_array($hasil);
    $kodeBarang = $data['maxKode'];

    // mengambil angka atau bilangan dalam kode anggota terbesar,
    // dengan cara mengambil substring mulai dari karakter ke-1 diambil 6 karakter
    // misal 'TRX00001', akan diambil '001'
    // setelah substring bilangan diambil lantas dicasting menjadi integer
    $noUrut = (int) substr($kodeBarang, 4, 5);

    // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
    $noUrut++;

    // membentuk kode anggota baru
    // perintah sprintf("%03s", $noUrut); digunakan untuk memformat string sebanyak 3 karakter
    // misal sprintf("%03s", 12); maka akan dihasilkan '012'
    // atau misal sprintf("%03s", 1); maka akan dihasilkan string '001'
    $char = "BRND";
    $kodeBarang = $char . sprintf("%05s", $noUrut);
    return $kodeBarang;
}

function noTipe(){
    include ('conn.php');
    // mencari kode barang dengan nilai paling besar
    $query = "SELECT MAX(tipe_no) as maxKode FROM tipe";
    $hasil = mysqli_query($con,$query);
    $data = mysqli_fetch_array($hasil);
    $kodeBarang = $data['maxKode'];

    // mengambil angka atau bilangan dalam kode anggota terbesar,
    // dengan cara mengambil substring mulai dari karakter ke-1 diambil 6 karakter
    // misal 'TRX00001', akan diambil '001'
    // setelah substring bilangan diambil lantas dicasting menjadi integer
    $noUrut = (int) substr($kodeBarang, 3, 5);

    // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
    $noUrut++;

    // membentuk kode anggota baru
    // perintah sprintf("%03s", $noUrut); digunakan untuk memformat string sebanyak 3 karakter
    // misal sprintf("%03s", 12); maka akan dihasilkan '012'
    // atau misal sprintf("%03s", 1); maka akan dihasilkan string '001'
    $char = "TYP";
    $kodeBarang = $char . sprintf("%05s", $noUrut);
    return $kodeBarang;
}

function noAloc(){
    include ('conn.php');
    // mencari kode barang dengan nilai paling besar
    $query = "SELECT MAX(aloc_no) as maxKode FROM asset_loc";
    $hasil = mysqli_query($con,$query);
    $data = mysqli_fetch_array($hasil);
    $kodeBarang = $data['maxKode'];

    // mengambil angka atau bilangan dalam kode anggota terbesar,
    // dengan cara mengambil substring mulai dari karakter ke-1 diambil 6 karakter
    // misal 'TRX00001', akan diambil '001'
    // setelah substring bilangan diambil lantas dicasting menjadi integer
    $noUrut = (int) substr($kodeBarang, 4, 5);

    // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
    $noUrut++;

    // membentuk kode anggota baru
    // perintah sprintf("%03s", $noUrut); digunakan untuk memformat string sebanyak 3 karakter
    // misal sprintf("%03s", 12); maka akan dihasilkan '012'
    // atau misal sprintf("%03s", 1); maka akan dihasilkan string '001'
    $char = "ALOC";
    $kodeBarang = $char . sprintf("%05s", $noUrut);
    return $kodeBarang;
}

function noSup(){
    include ('conn.php');
    // mencari kode barang dengan nilai paling besar
    $query = "SELECT MAX(sup_no) as maxKode FROM sup";
    $hasil = mysqli_query($con,$query);
    $data = mysqli_fetch_array($hasil);
    $kodeBarang = $data['maxKode'];

    // mengambil angka atau bilangan dalam kode anggota terbesar,
    // dengan cara mengambil substring mulai dari karakter ke-1 diambil 6 karakter
    // misal 'TRX00001', akan diambil '001'
    // setelah substring bilangan diambil lantas dicasting menjadi integer
    $noUrut = (int) substr($kodeBarang, 3, 5);

    // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
    $noUrut++;

    // membentuk kode anggota baru
    // perintah sprintf("%03s", $noUrut); digunakan untuk memformat string sebanyak 3 karakter
    // misal sprintf("%03s", 12); maka akan dihasilkan '012'
    // atau misal sprintf("%03s", 1); maka akan dihasilkan string '001'
    $char = "SUP";
    $kodeBarang = $char . sprintf("%05s", $noUrut);
    return $kodeBarang;
}

function noAsset(){
    include ('conn.php');
    // mencari kode barang dengan nilai paling besar
    $query = "SELECT MAX(asset_no) as maxKode FROM asset";
    $hasil = mysqli_query($con,$query);
    $data = mysqli_fetch_array($hasil);
    $kodeBarang = $data['maxKode'];

    // mengambil angka atau bilangan dalam kode anggota terbesar,
    // dengan cara mengambil substring mulai dari karakter ke-1 diambil 6 karakter
    // misal 'TRX00001', akan diambil '001'
    // setelah substring bilangan diambil lantas dicasting menjadi integer
    $noUrut = (int) substr($kodeBarang, 5, 5);

    // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
    $noUrut++;

    // membentuk kode anggota baru
    // perintah sprintf("%03s", $noUrut); digunakan untuk memformat string sebanyak 3 karakter
    // misal sprintf("%03s", 12); maka akan dihasilkan '012'
    // atau misal sprintf("%03s", 1); maka akan dihasilkan string '001'
    $char = "ASSET";
    $kodeBarang = $char . sprintf("%05s", $noUrut);
    return $kodeBarang;
}

function noTrade(){
    include ('conn.php');
    // mencari kode barang dengan nilai paling besar
    $query = "SELECT MAX(tradeno) as maxKode FROM trade";
    $hasil = mysqli_query($con,$query);
    $data = mysqli_fetch_array($hasil);
    $kodeBarang = $data['maxKode'];

    // mengambil angka atau bilangan dalam kode anggota terbesar,
    // dengan cara mengambil substring mulai dari karakter ke-1 diambil 6 karakter
    // misal 'TRX00001', akan diambil '001'
    // setelah substring bilangan diambil lantas dicasting menjadi integer
    $noUrut = (int) substr($kodeBarang, 3, 5);

    // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
    $noUrut++;

    // membentuk kode anggota baru
    // perintah sprintf("%03s", $noUrut); digunakan untuk memformat string sebanyak 3 karakter
    // misal sprintf("%03s", 12); maka akan dihasilkan '012'
    // atau misal sprintf("%03s", 1); maka akan dihasilkan string '001'
    $char = "TRX";
    $kodeBarang = $char . sprintf("%05s", $noUrut);
    return $kodeBarang;
}


function list_jasa(){
    include ('conn.php');
    $query = mysqli_query($con,"SELECT * FROM jasa ORDER BY jasa_nama ASC");
    $opt = "";
    while($row = mysqli_fetch_array($query)){
        $opt .= "<option value=\"".$row['idjasa']."\">".$row['jasa_nama']." - Rp. ".number_format($row['jasa_harga'],0,'','.')."</option>";
    }  
    return $opt; 
}

function list_cust(){
    include ('conn.php');
    $query = mysqli_query($con,"SELECT * FROM customer ORDER BY nama ASC");
    $opt = "";
    while($row = mysqli_fetch_array($query)){
        $opt .= "<option value=\"".$row['idcust']."\">".$row['nama']."</option>";
    }  
    echo $opt; 
}



function list_cat(){
    include ('conn.php');
    $query = mysqli_query($con,"SELECT * FROM category ORDER BY namacat ASC");
    $opt = "";
    while($row = mysqli_fetch_array($query)){
        $opt .= "<option value=\"".$row['idcat']."\">".$row['namacat']."</option>";
    }  
    echo $opt; 
}

function list_sup(){
    include ('conn.php');
    $query = mysqli_query($con,"SELECT * FROM sup ORDER BY sup_name ASC");
    $opt = "";
    while($row = mysqli_fetch_array($query)){
        $opt .= "<option value=\"".$row['id_sup']."\">".$row['sup_name']."</option>";
    }  
    echo $opt; 
}

function list_aloc(){
    include ('conn.php');
    $query = mysqli_query($con,"SELECT id_aloc, aloc_name FROM asset_loc UNION SELECT idcust as id_aloc, nama as aloc_name from customer order by 2");
    $opt = "";
    while($row = mysqli_fetch_array($query)){
        $opt .= "<option value=\"".$row['id_aloc']."\">".$row['aloc_name']."</option>";
    }  
    echo $opt; 
}

function list_asloc(){
    include ('conn.php');
    $query = mysqli_query($con,"SELECT * FROM asset_loc ORDER BY aloc_name ASC");
    $opt = "";
    while($row = mysqli_fetch_array($query)){
        $opt .= "<option value=\"".$row['id_aloc']."\">".$row['aloc_name']."</option>";
    }  
    echo $opt; 
}

function list_brand1(){
    include ('conn.php');
    $query = mysqli_query($con,"SELECT * FROM brand x JOIN category x1 WHERE x1.idcat=x.idcat ORDER BY x.namabrand ASC");
    $opt = "";
    while($row = mysqli_fetch_array($query)){
        $opt .= "<option value=\"".$row['idbrand']."\">".$row['namabrand']."</option>";
    }  
    return $opt; 
}

function list_brand2($idcat){
    include ('conn.php');
    $query = mysqli_query($con,"SELECT * FROM brand WHERE idcat=$idcat ORDER BY namabrand ASC");
    $opt1 = '<option value="">-- Choose Brand --</option>';
    while($row = mysqli_fetch_array($query)){
        $opt1 .= "<option value=\"".$row['idbrand']."\">".$row['namabrand']."</option>";
    }  
    echo $opt1; 
}

function list_cust1($idjasa){
    include ('conn.php');
    $query = mysqli_query($con,"SELECT * FROM customer WHERE id_jasa='$idjasa' ORDER BY nama ASC");
    $opt1 = '<option value="">-- Pilih Customer --</option>';
    while($row = mysqli_fetch_array($query)){
        $opt1 .= "<option value=\"".$row['idcust']."\">".$row['nama']."</option>";
    }  
    echo $opt1; 
}

function list_jj(){
    include ('conn.php');
    $query = mysqli_query($con,"SELECT * FROM jenis_jasa ORDER BY nama_jasa ASC");
    $opt = "";
    while($row = mysqli_fetch_array($query)){
        $opt .= "<option value=\"".$row['id_jasa']."\">".$row['nama_jasa']." - Rp.".$row['biaya']."</option>";
    }  
    echo $opt; 
}

function list_tipe($idbrand){
    include ('conn.php');
    $query = mysqli_query($con,"SELECT * FROM tipe WHERE idbrand=$idbrand ORDER BY namatipe ASC");
    $opt = '<option value="">-- Choose Tipe --</option>';
    while($row = mysqli_fetch_array($query)){
        $opt .= "<option value=\"".$row['idtipe']."\">".$row['namatipe']."</option>";
    }  
    echo $opt; 
}


function list_guru(){
    include ('conn.php');
    $query = mysqli_query($con,"SELECT * FROM guru ORDER BY guru_nama ASC");
    $opt = "";
    while($row = mysqli_fetch_array($query)){
        $opt .= "<option value=\"".$row['idguru']."\">".$row['guru_nip']." - ".$row['guru_nama']."</option>";
    }  
    return $opt; 
}

function list_tapel(){
    include ('conn.php');
    $query = mysqli_query($con,"SELECT * FROM tahun_pelajaran ORDER BY idtahun_pelajaran DESC");
    $opt = "";
    while($row = mysqli_fetch_array($query)){
        $opt .= "<option value=\"".$row['idtahun_pelajaran']."\">".$row['nama_tapel']."/".$row['semester_tapel']."</option>";
    }  
    return $opt; 
}

function list_mapel(){
    include ('conn.php');
    $mapel = mysqli_query($con,"SELECT * FROM mata_pelajaran x JOIN kelas x1 ON x.kelas_id=x1.idkelas JOIN guru x2 ON x.guru_id=x2.idguru ORDER BY mapel_nama ASC");
    $opt = "";
    while($row2 = mysqli_fetch_array($mapel)){
        $opt .= "<option value=\"".$row2['idmata_pelajaran']."\">".$row2['mapel_kode']." - ".$row2['mapel_nama']." - ".$row2['kelas_kode']."</option>";
    } 
    return $opt; 
}

function list_mapel_by_guru(){
    include ('conn.php');
    $guru = mysqli_fetch_array(mysqli_query($con,"SELECT idguru FROM guru WHERE guru_nip='".$_SESSION['username']."'"));
    $mapel = mysqli_query($con,"SELECT * FROM mata_pelajaran x JOIN kelas x1 ON x.kelas_id=x1.idkelas JOIN guru x2 ON x.guru_id=x2.idguru WHERE x2.idguru='".$guru['idguru']."' ORDER BY mapel_nama ASC");
    $opt = "";
    while($row2 = mysqli_fetch_array($mapel)){
        $opt .= "<option value=\"".$row2['idmata_pelajaran']."\">".$row2['mapel_kode']." - ".$row2['mapel_nama']." - ".$row2['kelas_kode']."</option>";
    } 
    return $opt; 
}

function encrypt($str) {
return base64_encode($str);
}
function decrypt($str) {
return base64_decode($str);
}

function base_url(){
    $base_url= ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
    $base_url.= "://".$_SERVER['HTTP_HOST'];
    $base_url.= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
    return $base_url;
}
?>