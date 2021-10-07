<?php hakAkses(['Admin','User']); date_default_timezone_set("Asia/Jakarta"); ?>
<script>
function submit(x) {
    if (x == 'add') {
        $('[name="tipe_no"]').val("<?=noTipe();?>");
        $('[name="idcat"]').val("").trigger('change');
        $('[name="idbrand"]').val("").trigger('change');
        $('[name="namatipe"]').val("");
        $('#transaksiModal .modal-title').html('Add Type');
        $('[name="tipe_no"]').prop('readonly', false);
        $('[name="ubah"]').hide();
        $('[name="tambah"]').show();
    } else {
        $('#transaksiModal .modal-title').html('Edit Type');
        $('[name="tipe_no"]').prop('readonly', false);
        $('[name="tambah"]').hide();
        $('[name="ubah"]').show();

        $.ajax({
            type: "POST",
            data: {
                id: x
            },
            url: '<?=base_url();?>process/view_tipe.php',
            dataType: 'json',
            success: function(data) {
                $('[name="idtipe"]').val(data.idtipe);
                $('[name="namatipe"]').val(data.namatipe);
                $('[name="tipe_no"]').val(data.tipe_no);
                $('[name="idcat"]').val(data.idcat).trigger('change');
                setTimeout(
                    function() 
                    {
                        $('[name="idbrand"]').val(data.idbrand).trigger('change');
                    }, 500);

            }
        });
    }
}




</script>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Type</h1>
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
                            <th width="20">NO</th>
                            <th>Category Name</th>
                            <th>Brand Name</th>
                            <th>Type</th>
                            <th width="50">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $n=1;
                        $query = mysqli_query($con,"SELECT * FROM category x, brand x1, tipe x2 WHERE x2.idbrand=x1.idbrand and x2.idcat=x.idcat ORDER BY x.namacat DESC") or die(mysqli_error($con));
                        while($row = mysqli_fetch_array($query)):
                        ?>
                        <tr>
                            <td><?= $n++; ?></td>
                            <td><?= $row['namacat']; ?></td>
                            <td><?= $row['namabrand']; ?></td>
                            <td><?= $row['namatipe']; ?></td>
                            <td>
                                <a href="#transaksiModal" data-toggle="modal"
                                    onclick="submit(<?=$row['idtipe'];?>)" class="btn btn-sm btn-circle btn-info"
                                    data-toggle="tooltip" data-placement="top" title="Ubah Data"><i
                                        class="fas fa-edit"></i></a>
                                <a href="<?=base_url();?>process/tipe.php?act=<?=encrypt('delete');?>&id=<?=encrypt($row['idtipe']);?>"
                                    class="btn btn-sm btn-circle btn-danger btn-hapus" data-toggle="tooltip"
                                    data-placement="top" title="Hapus Data"><i class="fas fa-trash"></i></a>
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
            <form action="<?=base_url();?>process/tipe.php" method="post">
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
                                <label for="tipe_no">No. Type <span class="text-danger">*</span></label>
                                <input type="hidden" name="tipe_no">
                                <input type="text" class="form-control" id="tipe_no" name="tipe_no"
                                    value="<?= noTipe(); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="namatipe">Type Name <span class="text-danger">*</span></label>
                                <input name="namatipe" id="namatipe" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
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