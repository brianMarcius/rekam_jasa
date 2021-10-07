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
        $('[name="id_type"]').val("");
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
                $('[name="status"]').val(data.status).trigger('change');
            }
        });

        if (view) {
            $('#transaksiModal .modal-title').html('View Customer');
            $("#transaksiModal input").prop("disabled", true);
            $("#transaksiModal select").prop("disabled", true);
            $("[name='ubah']").hide();
        }
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
                            <th width="5%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $n=1;
                        $query = mysqli_query($con,"SELECT * FROM customer ORDER BY cust_no DESC")or die(mysqli_error($con));
                        while($row = mysqli_fetch_array($query)):
                        ?>
                        <tr>
                            <td><?= $n++; ?></td>
                            <td><?= $row['nama']; ?></td>
                            <td><center><?= $row['status']; ?></center></td>
                            <td><center>
                                <a href="#transaksiModal" data-toggle="modal"
                                    onclick="submit(<?=$row['idcust'];?>,1)" class="btn btn-sm btn-circle btn-warning"
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cust_no">Nomor Transaksi <span class="text-danger">*</span></label>
                                <input type="hidden" name="idcust">
                                <input type="text" class="form-control" id="cust_no" name="cust_no"
                                    value="<?= noCustomer(); ?>" required>
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