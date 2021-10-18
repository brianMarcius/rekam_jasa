<?php hakAkses(['Admin','User']); date_default_timezone_set("Asia/Jakarta"); ?>
<script>
function submit(x,view = 0) {
    if (x == 'add') {
        $('[name="cust_no"]').val("<?=noCustomer();?>");
        $('[name="nama"]').val("");
        $('[name="addr"]').val("");
        $('[name="phn"]').val("");
        $('[name="nik"]').val("");
        $('[name="ins"]').val("");
        $('[name="exp"]').val("");
        $('[name="id_type"]').val("").trigger('change');
        $('[name="id_jasa"]').val("").trigger('change');
        $('[name="status"]').val("");
        $('#transaksiModal .modal-title').html('Add Customer');
        $('[name="cust_no"]').prop('readonly', false);
        $('[name="ubah"]').hide();
        $('[name="tambah"]').show();
    } else {
        $("#transaksiModal input").prop("disabled", false);
        $("#transaksiModal select").prop("disabled", false);
        
        $('#transaksiModal .modal-title').html('Edit Customer');
        $('[name="cust_no"]').prop('readonly', false);
        $('[name="tambah"]').hide();
        $('[name="ubah"]').show();

        $.ajax({
            type: "POST",
            data: {
                id: x
            },
            url: '<?=base_url();?>process/view_listcust.php',
            dataType: 'json',
            success: function(data) {
                $('[name="idcust"]').val(data.idcust);
                $('[name="cust_no"]').val(data.cust_no);
                $('[name="nama"]').val(data.nama);
                $('[name="addr"]').val(data.addr);
                $('[name="phn"]').val(data.phn);
                $('[name="nik"]').val(data.nik);
                $('[name="ins"]').val(data.ins);
                $('[name="exp"]').val(data.exp);
                $('[name="id_type"]').val(data.id_type).trigger('change');
                $('[name="id_jasa"]').val(data.id_jasa).trigger('change');
                $('[name="status"]').val(data.status).trigger('change');

                if (view) {
                    $('#viewModal .modal-title').html('Detail Customer');
                    $('#view_no_transaksi').html(data.cust_no);
                    $('#view_customer_name').html(data.nama);
                    $('#view_customer_address').html(data.addr);
                    $('#view_customer_phone').html(data.phn);
                    $('#view_customer_identity').html(data.nik);
                    $('#view_installation_date').html(data.ins);
                    $('#view_expired_date').html(data.exp);
                    $('#view_identity_type').html(data.id_type);
                    $('#view_jasa').html(data.nama_jasa);
                    $('#view_biaya').html(data.biaya);
                    $('#view_service_status').html(data.status);
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
        <h1 class="h3 mb-0 text-gray-800">Customer</h1>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal" data-target="#transaksiModal"
                onclick="submit('add')">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Add Customer</span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="1%">NO</th>
                            <th width="40%">Customer Name</th>
                            <th width="10%">Service Status</th>
                            <th width="1%"><center>&nbsp;&nbsp;&nbsp;&nbsp;Action&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $n=1;
                        $query = mysqli_query($con,"SELECT * FROM customer WHERE data_status='Enable' ORDER BY cust_no DESC")or die(mysqli_error($con));
                        while($row = mysqli_fetch_array($query)):
                        ?>
                        <tr>
                        <td><center><?= $n++; ?></center></td>
                            <td><?= $row['nama']; ?></td>
                            <td><center><?= $row['status']; ?></center></td>
                            <td><center>
                                <a href="#viewModal" data-toggle="modal"
                                    onclick="submit(<?=$row['idcust'];?>,'1')" class="btn btn-sm btn-circle btn-warning"
                                    data-toggle="tooltip" data-placement="top" title="View Data"><i
                                        class="fas fa-eye"></i></a>
                                <a href="#transaksiModal" data-toggle="modal"
                                    onclick="submit(<?=$row['idcust'];?>)" class="btn btn-sm btn-circle btn-info"
                                    data-toggle="tooltip" data-placement="top" title="Ubah Data"><i
                                        class="fas fa-edit"></i></a>
                                <a href="<?=base_url();?>process/listcust.php?act=<?=encrypt('delete');?>&idcust=<?=encrypt($row['idcust']);?>"
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
            <form action="<?=base_url();?>process/listcust.php" method="post">
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
                                <label for="cust_no">Nomor Transaksi <span class="text-danger">*</span></label>
                                <input type="hidden" name="idcust">
                                <input type="text" class="form-control" id="cust_no" name="cust_no"
                                    value="<?= noCustomer(); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="nama">Customer Name <span class="text-danger">*</span></label>
                                <input name="nama" id="nama" type="text" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="ins">Installation Date  <span class="text-danger">*</span></label>
                                <input name="ins" id="ins" type="date" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="addr">Customer Address <span class="text-danger">*</span></label>
                                <input name="addr" id="addr" type="text" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exp">Expired Date <span class="text-danger">*</span></label>
                                <input name="exp" id="exp" type="date" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phn">Customer Phone <span class="text-danger">*</span></label>
                                <input name="phn" id="phn" type="text"  class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nik">Customer Identity <span class="text-danger">*</span></label>
                                <input name="nik" id="nik" type="text" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Identity Type <span class="text-danger">*</span></label>
                                <select name="id_type" class="form-control" required>
                                    <option value="KTP">KTP</option>
                                    <option value="NPWP">NPWP</option>
                                    <option value="PASSPORT">PASSPORT</option>
                                    <option value="SIM">SIM</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_jasa">Input Jasa <span class="text-danger">*</span></label>
                                <select name="id_jasa" id="id_jasa" class="form-control select2"
                                    style="width:100%;" required>
                                    <option value="">-- Choose Jasa --</option>
                                    <?= list_jj(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Set Service Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-control" required>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>   
                    </div>
                    
                    <hr class="sidebar-divider">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fas fa-times"></i>
                        Batal</button>
                    <button class="btn btn-primary float-right" type="submit" name="tambah"><i class="fas fa-check"></i>
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
                                        <td style="width:10%; padding:5px"><label class="font-weight-bold" for="view_customer_name">Customer Name</label></td>
                                        <td style="width:3%; padding:5px">:</td>
                                        <td style="width:25%; padding:5px"><span id="view_customer_name"></span></td>
                                        <td style="width:3%; padding:5px"> </td>
                                        <td style="width:10%; padding:5px"><label class="font-weight-bold" for="view_installation_date">Installation Date </label></td>
                                        <td style="width:3%; padding:5px">:</td>
                                        <td style="width:25%; padding:5px"><span id="view_installation_date"></span></td>
                                    </tr>
                                    <tr>
                                        <td style="width:10%; padding:5px"><label class="font-weight-bold" for="ins">Customer Address </label></td>
                                        <td style="width:3%; padding:5px">:</td>
                                        <td style="width:25%; padding:5px"><span id="view_customer_address"></span></td>
                                        <td style="width:3%; padding:5px"> </td>
                                        <td style="width:10%; padding:5px"><label class="font-weight-bold" for="view_expired_date">Expired Date </label></td>
                                        <td style="width:3%; padding:5px">:</td>
                                        <td style="width:25%; padding:5px"><span id="view_expired_date"></span></td>
                                    </tr>
                                    <tr>
                                        <td style="width:10%; padding:5px"><label class="font-weight-bold" for="view_customer_phone">Customer Phone </label></td>
                                        <td style="width:3%; padding:5px">:</td>
                                        <td style="width:25%; padding:5px"><span id="view_customer_phone"></span></td>
                                        <td style="width:3%; padding:5px"> </td>
                                        <td style="width:10%; padding:5px"><label class="font-weight-bold" for="view_customer_identity">Customer Identity </label></td>
                                        <td style="width:3%; padding:5px">:</td>
                                        <td style="width:25%; padding:5px"><span id="view_customer_identity"></span></td>
                                    </tr>
                                    <tr>
                                        <td style="width:10%; padding:5px"><label class="font-weight-bold" for="view_no_transaksi">No Transaksi </label></td>
                                        <td style="width:3%; padding:5px">:</td>
                                        <td style="width:25%; padding:5px"><span id="view_no_transaksi"></span></td>
                                        <td style="width:3%; padding:5px"> </td>
                                        <td style="width:10%; padding:5px"><label class="font-weight-bold" for="view_identity_type">Identity Type </label></td>
                                        <td style="width:3%; padding:5px">:</td>
                                        <td style="width:25%; padding:5px"><span id="view_identity_type"></span></td>
                                    </tr>
                                    <tr>
                                        <td style="width:10%; padding:5px"><label class="font-weight-bold" for="view_jasa">Jasa </label></td>
                                        <td style="width:3%; padding:5px">:</td>
                                        <td style="width:25%; padding:5px"><span id="view_jasa"></span>&nbsp;&nbsp;-&nbsp;
                                        
                                        <label for="view_biaya">Rp. </label>
                                        <span id="view_biaya"></span></td>
                                        <td style="width:3%; padding:5px"> </td>
                                        <td style="width:10%; padding:5px"><label class="font-weight-bold" for="view_service_status">Status </label></td>
                                        <td style="width:3%; padding:5px">:</td>
                                        <td style="width:25%; padding:5px"><span class="badge badge-success" id="view_service_status"></span></td>
                                    </tr>
                                </table>
                                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="1%">NO</th>
                                            <th width="40%">Asset Name</th>
                                            <th width="1%"><center>&nbsp;&nbsp;&nbsp;&nbsp;Action&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $n=1;
                                        $query = mysqli_query($con,"SELECT * FROM asset WHERE data_status='Enable' ORDER BY id_asset DESC")or die(mysqli_error($con));
                                        while($row = mysqli_fetch_array($query)):
                                        ?>
                                        <tr>
                                        <td><center><?= $n++; ?></center></td>
                                            <td><?= $row['nama_asset']; ?></td>
                                            <td><center><?= $row['status']; ?></center></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
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