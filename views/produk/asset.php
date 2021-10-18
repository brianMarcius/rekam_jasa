<?php hakAkses(['Admin','User']); date_default_timezone_set("Asia/Jakarta"); ?>
<script>
function submit(x,view = 0) {
    if (x == 'add') {
        $('[name="asset_no"]').val("<?=noAsset();?>");
        $('[name="idcat"]').val("").trigger('change');
        $('[name="idbrand"]').val("").trigger('change');
        $('[name="id_aloc"]').val("").trigger('change');
        $('[name="id_sup"]').val("").trigger('change');
        $('[name="idtipe"]').val("").trigger('change');
        $('[name="nama_asset"]').val("");
        $('[name="sn"]').val("");
        $('[name="pd"]').val("");
        $('[name="harga"]').val("");
        $('[name="status"]').val("");
        $('[name="descr"]').val("");
        $('#transaksiModal .modal-title').html('Add Asset');
        $('[name="asset_no"]').prop('readonly', false);
        $('[name="ubah"]').hide();
        $('[name="tambah"]').show();
    } else {
        $('#transaksiModal .modal-title').html('Edit Type');
        $('[name="asset_no"]').prop('readonly', false);
        $('[name="tambah"]').hide();
        $('[name="ubah"]').show();

        $.ajax({
            type: "POST",
            data: {
                id: x
            },
            url: '<?=base_url();?>process/view_asset.php',
            dataType: 'json',
            success: function(data) {
                $('[name="id_asset"]').val(data.id_asset);
                $('[name="asset_no"]').val(data.asset_no);
                $('[name="nama_asset"]').val(data.nama_asset);
                $('[name="sn"]').val(data.sn);
                $('[name="pd"]').val(data.pd);
                $('[name="harga"]').val(data.harga);
                $('[name="status"]').val(data.status);
                $('[name="descr"]').val(data.descr);
                $('[name="idcat"]').val(data.idcat).trigger('change');
                setTimeout(
                    function() 
                    {
                        $('[name="idbrand"]').val(data.idbrand).trigger('change');
                    }, 300);
                
                $('[name="id_aloc"]').val(data.id_aloc).trigger('change');
                $('[name="id_sup"]').val(data.id_sup).trigger('change');
                setTimeout(
                    function() 
                    {
                        $('[name="idtipe"]').val(data.idtipe).trigger('change');
                    }, 500);
                
                if (view) {
                    $('#viewModal .modal-title').html('Detail Asset');
                    $('#view_asset_no').html(data.asset_no);
                    $('#view_nama_asset').html(data.nama_asset);
                    $('#view_sn').html(data.sn);
                    $('#view_pd').html(data.pd);
                    $('#view_harga').html(data.harga);
                    $('#view_descr').html(data.descr);
                    $('#view_namacat').html(data.namacat);
                    $('#view_namabrand').html(data.namabrand);
                    $('#view_namatipe').html(data.namatipe);
                    $('#view_sup_name').html(data.sup_name);
                    $('#view_status').html(data.status);
                    if (data.status=='Active') {
                        $('#view_service_status').removeClass('badge-danger');
                        $('#view_service_status').addClass('badge-success');
                    }else{
                        $('#view_service_status').removeClass('badge-success');
                        $('#view_service_status').addClass('badge-danger');
                    }
                }
                
            }
        });
    }
}




</script>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Asset</h1>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal" data-target="#transaksiModal"
                onclick="submit('add')">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah</span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="1%">NO</th>
                            <th width="25%">Asset Name</th>
                            <th width="10%">Serial Number</th>
                            <th width="15%">Location</th>
                            <th width="3%">Status</th>
                            <th width="1%"><center>&nbsp;&nbsp;&nbsp;&nbsp;Action&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $n=1;
                        $query = mysqli_query($con,"SELECT * FROM asset x, brand x1, category x2, asset_loc x3, sup x4, tipe x5, customer c
                         WHERE x.idbrand=x1.idbrand and x.idcat=x2.idcat and x.id_sup=x4.id_sup and x.idtipe=x5.idtipe 
                         and x.data_status = 'Enable' and x.id_aloc=c.idcust ORDER BY x.nama_asset DESC") or die(mysqli_error($con));
                        while($row = mysqli_fetch_array($query)):
                        ?>
                        <tr>
                            <td><center><?= $n++; ?></center></td>
                            <td><?= $row['nama_asset']; ?></td>
                            <td><?= $row['sn']; ?></td>
                            <td><?= $row['aloc_name']; ?></td>
                            <td><center><?= $row['status']; ?></center></td>
                            <td><center>
                                <a href="#viewModal" data-toggle="modal"
                                    onclick="submit(<?=$row['id_asset'];?>,'1')" class="btn btn-sm btn-circle btn-warning"
                                    data-toggle="tooltip" data-placement="top" title="View Data"><i
                                        class="fas fa-eye"></i></a>
                                <a href="#transaksiModal" data-toggle="modal"
                                    onclick="submit(<?=$row['id_asset'];?>)" class="btn btn-sm btn-circle btn-info"
                                    data-toggle="tooltip" data-placement="top" title="Ubah Data"><i
                                        class="fas fa-edit"></i></a>
                                        <a href="<?=base_url();?>process/asset.php?act=<?=encrypt('delete');?>&id_asset=<?=encrypt($row['id_asset']);?>"
                                    class="btn btn-sm btn-circle btn-danger btn-hapus" data-toggle="tooltip"
                                    data-placement="top" title="Hapus Data"><i class="fas fa-trash"></i></a>
                        </center>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- Modal Tambah kelas -->
<div class="modal fade" id="transaksiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="<?=base_url();?>process/asset.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="asset_no">No. Type <span class="text-danger">*</span></label>
                                <input type="hidden" name="asset_no">
                                <input type="text" class="form-control" id="asset_no" name="asset_no"
                                    value="<?= noAsset(); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6 offset-md-2">
                            <div class="form-group">
                                <label for="idcat">Input Category <span class="text-danger">*</span></label>
                                <select name="idcat" id="idcat" class="form-control select2"
                                    style="width:100%;" required>
                                    <option value="">-- Choose Category --</option>
                                    <?= list_cat(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="idbrand">Input Brand <span class="text-danger">*</span></label>
                                <select name="idbrand" id="idbrand" class="form-control select2"
                                    style="width:100%;" required>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="idtipe">Input Tipe <span class="text-danger">*</span></label>
                                <select name="idtipe" id="idtipe" class="form-control select2"
                                    style="width:100%;" required>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_aloc">Input Location <span class="text-danger">*</span></label>
                                <select name="id_aloc" id="id_aloc" class="form-control select2"
                                    style="width:100%;" required>
                                    <option value="">-- Choose Location --</option>
                                    <?= list_aloc(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_sup">Input Supplier <span class="text-danger">*</span></label>
                                <select name="id_sup" id="id_sup" class="form-control select2"
                                    style="width:100%;" required>
                                    <option value="">-- Choose Supplier --</option>
                                    <?= list_sup(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="nama_asset">Asset Name <span class="text-danger">*</span></label>
                                <input name="nama_asset" id="nama_asset" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="harga">Harga Produk <span class="text-danger">*</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="harga">Rp.</span>
                                </div>
                                <input type="text" class="form-control" name="harga"
                                    aria-describedby="harga">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="sn">Serial Number <span class="text-danger">*</span></label>
                                <input name="sn" id="sn" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="pd">Purchase Date <span class="text-danger">*</span></label>
                                <input name="pd" id="pd" type="date" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="descr">Description <span class="text-danger"></span></label>
                                <input name="descr" id="descr" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="Active">Active</option>
                                    <option value="Rusak">Rusak</option>
                                    <option value="Hilang">Hilang</option>
                                    <option value="Perbaikan">Perbaikan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr class="sidebar-divider">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fas fa-times"></i>
                        Batal</button>
                    <button class="btn btn-primary float-right" type="submit" name="tambah"><i class="fas fa-save"></i>
                        Tambah</button>
                    <button class="btn btn-primary float-right" type="submit" name="ubah"><i class="fas fa-save"></i>
                        Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel"
    aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="<?=base_url();?>#" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tr>
                                        <td style="width:5%; padding:0px"><label class="font-weight-bold" for="view_nama_asset">Asset Name</label></td>
                                        <td style="width:1%; padding:0px">:</td>
                                        <td style="width:25%; padding:0px"><span id="view_nama_asset"></span></td>
                                    </tr><tr>
                                        <td style="width:5%; padding:0px"><label class="font-weight-bold" for="view_sn">Serial Number </label></td>
                                        <td style="width:1%; padding:0px">:</td>
                                        <td style="width:25%; padding:0px"><span id="view_sn"></span></td>
                                    </tr>
                                    <tr>
                                        <td style="width:5%; padding:0px"><label class="font-weight-bold" for="view_pd">Purchase Date </label></td>
                                        <td style="width:1%; padding:0px">:</td>
                                        <td style="width:25%; padding:0px"><span id="view_pd"></span></td>
                                    </tr><tr>
                                        <td style="width:5%; padding:0px"><label class="font-weight-bold" for="view_harga">Harga Barang </label></td>
                                        <td style="width:1%; padding:0px">:</td>
                                        <td style="width:25%; padding:0px"><span id="view_harga"></span></td>
                                    </tr>
                                    <tr>
                                        <td style="width:5%; padding:0px"><label class="font-weight-bold" for="view_descr">Deskripsi </label></td>
                                        <td style="width:1%; padding:0px">:</td>
                                        <td style="width:25%; padding:0px"><span id="view_descr"></span></td>
                                    </tr><tr>
                                        <td style="width:5%; padding:0px"><label class="font-weight-bold" for="view_namacat">Kategori </label></td>
                                        <td style="width:1%; padding:0px">:</td>
                                        <td style="width:25%; padding:0px"><span id="view_namacat"></span></td>
                                    </tr>
                                    <tr>
                                        <td style="width:5%; padding:0px"><label class="font-weight-bold" for="view_namabrand">Brand </label></td>
                                        <td style="width:1%; padding:0px">:</td>
                                        <td style="width:25%; padding:0px"><span id="view_namabrand"></span></td>
                                    </tr><tr>
                                        <td style="width:5%; padding:0px"><label class="font-weight-bold" for="view_namatipe">Tipe </label></td>
                                        <td style="width:1%; padding:0px">:</td>
                                        <td style="width:25%; padding:0px"><span id="view_namatipe"></span></td>
                                    </tr>
                                    <tr>
                                        <td style="width:5%; padding:0px"><label class="font-weight-bold" for="view_sup_name">Supplier </label></td>
                                        <td style="width:1%; padding:0px">:</td>
                                        <td style="width:25%; padding:0px"><span id="view_sup_name"></span></td>
                                    </tr><tr>
                                        <td style="width:5%; padding:0px"><label class="font-weight-bold" for="view_status">Status </label></td>
                                        <td style="width:1%; padding:0px">:</td>
                                        <td style="width:25%; padding:0px"><span class="badge badge-success" id="view_status"></span></td>
                                    </tr>
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="sidebar-divider">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fas fa-times"></i>
                        Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>