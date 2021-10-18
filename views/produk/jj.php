<?php hakAkses(['Admin','User']); date_default_timezone_set("Asia/Jakarta"); ?>
<script>
function submit(x) {
    if (x == 'add') {
        $('[name="jasa_no"]').val("<?=noJJ();?>");
        $('[name="nama_jasa"]').val("");
        $('[name="rincian"]').val("");
        $('[name="biaya"]').val("");
        $('#transaksiModal .modal-title').html('Tambah Jasa');
        $('[name="jasa_no"]').prop('readonly', false);
        $('[name="ubah"]').hide();
        $('[name="tambah"]').show();
    } else {
        $('#transaksiModal .modal-title').html('Edit Jasa');
        $('[name="jasa_no"]').prop('readonly', false);
        $('[name="tambah"]').hide();
        $('[name="ubah"]').show();

        $.ajax({
            type: "POST",
            data: {
                id: x
            },
            url: '<?=base_url();?>process/view_jj.php',
            dataType: 'json',
            success: function(data) {
                $('[name="id_jasa"]').val(data.id_jasa);
                $('[name="jasa_no"]').val(data.jasa_no);
                $('[name="nama_jasa"]').val(data.nama_jasa);
                $('[name="rincian"]').val(data.rincian);
                $('[name="biaya"]').val(data.biaya);
                
            }
        });
    }
}
</script>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Jenis Jasa</h1>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal" data-target="#transaksiModal"
                onclick="submit('add')">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah Jasa</span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="20">NO</th>
                            <th>Nama Jasa</th>
                            <th>Biaya</th>
                            <th width="1%"><center>&nbsp;&nbsp;&nbsp;&nbsp;Action&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $n=1;
                        $query = mysqli_query($con,"SELECT * FROM jenis_jasa WHERE data_status='Enable' ORDER BY jasa_no DESC")or die(mysqli_error($con));
                        while($row = mysqli_fetch_array($query)):
                        ?>
                        <tr>
                        <td><center><?= $n++; ?></center></td>
                            <td><?= $row['nama_jasa']; ?></td>
                            <td><?= 'Rp. '.number_format($row['biaya'],0,'','.'); ?></td>
                            <td><center>
                                <a href="#transaksiModal" data-toggle="modal"
                                    onclick="submit(<?=$row['id_jasa'];?>)" class="btn btn-sm btn-circle btn-info"
                                    data-toggle="tooltip" data-placement="top" title="Ubah Data"><i
                                        class="fas fa-edit"></i></a>
                                <a href="<?=base_url();?>process/jj.php?act=<?=encrypt('delete');?>&id_jasa=<?=encrypt($row['id_jasa']);?>"
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
            <form action="<?=base_url();?>process/jj.php" method="post">
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
                                <label for="jasa_no">Nomor jasa<span class="text-danger">*</span></label>
                                <input type="hidden" name="jasa_no">
                                <input type="text" class="form-control" id="jasa_no" name="jasa_no"
                                    value="<?= noJJ(); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="nama_jasa">Nama Jasa <span class="text-danger">*</span></label>
                                <input name="nama_jasa" id="nama_jasa" type="text" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="rincian">Dekripsi</span></label>
                                <input name="rincian" id="rincian" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="biaya">Harga Jasa <span class="text-danger">*</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="biaya">Rp.</span>
                                </div>
                                <input type="text" class="form-control" name="biaya"
                                    aria-describedby="biaya">
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