<?php hakAkses(['Admin','User']); date_default_timezone_set("Asia/Jakarta"); ?>
<script>
function submit(x) {
    if (x == 'add') {
        $('[name="cust_no"]').val("<?=noCustomer();?>");
        $('[name="nama"]').val("");
        $('[name="addr"]').val("");
        $('[name="phn"]').val("");
        $('[name="nik"]').val("");
        $('[name="ins"]').val("");
        $('[name="exp"]').val("");
        $('[name="id_type"]').val("");
        $('#transaksiModal .modal-title').html('Add Customer');
        $('[name="cust_no"]').prop('readonly', true);
        $('[name="ubahexp"]').hide();
        $('[name="tambah"]').show();
    } else {
        $('#transaksiModal .modal-title').html('Edit Customer');
        $('[name="cust_no"]').prop('readonly', true);
        $('[name="tambah"]').hide();
        $('[name="ubahexp"]').show();

        $.ajax({
            type: "POST",
            data: {
                id: x
            },
            url: '<?=base_url();?>process/_listcust.php',
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
                $('[name="id_type"]').val(data.id_type);
            }
        });
    }
}
</script>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Has Expired</h1>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="20">NO</th>
                            <th>Customer Name</th>
                            <th>KTP/NIK</th>
                            <th>Address</th>
                            <th>Installation Date</th>
                            <th>Expired Date</th>
                            <th width="50">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $n=1;
                        $query = mysqli_query($con,"SELECT * FROM customer WHERE exp < DATE(NOW()) ORDER BY exp ASC")or die(mysqli_error($con));
                        while($row = mysqli_fetch_array($query)):
                        ?>
                        <tr>
                            <td><?= $n++; ?></td>
                            <td><?= $row['nama']; ?></td>
                            <td><?= $row['nik']; ?></td>
                            <td><?= $row['addr']; ?></td>
                            <td><?= $row['ins']; ?></td>
                            <td><?= $row['exp']; ?></td>
                            <td><center>
                                <a href="#transaksiModal" data-toggle="modal"
                                    onclick="submit(<?=$row['idcust'];?>)" class="btn btn-sm btn-circle btn-info"
                                    data-toggle="tooltip" data-placement="top" title="Ubah Data"><i
                                        class="fas fa-edit"></i></a>
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
                                <label>Identity Type</label>
                                <select name="id_type" class="form-control" required>
                                    <option value="KTP">KTP</option>
                                    <option value="NPWP">NPWP</option>
                                    <option value="PASSPORT">PASSPORT</option>
                                    <option value="SIM">SIM</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="sidebar-divider">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fas fa-times"></i>
                        Batal</button>
                    <button class="btn btn-primary float-right" type="submit" name="tambah"><i class="fas fa-save"></i>
                        Tambah</button>
                    <button class="btn btn-primary float-right" type="submit" name="ubahexp"><i class="fas fa-save"></i>
                        Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>