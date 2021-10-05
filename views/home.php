<?php hakAkses(['Admin','User']); date_default_timezone_set("Asia/Jakarta"); ?>
<script>
function submit(x) {
    if (x == 'add') {
        $('[name="transaksi_no"]').val("<?=noTransaksi();?>");
        $('[name="jenis_jasa"]').val("").trigger('change');
        $('[name="transaksi_nama"]').val("");
        $('[name="transaksi_jumlah"]').val("");
        $('#transaksiModal .modal-title').html('Tambah Transaksi');
        $('[name="transaksi_no"]').prop('readonly', false);
        $('[name="ubah"]').hide();
        $('[name="tambah"]').show();
    } else {
        $('#transaksiModal .modal-title').html('Edit Transaksi');
        $('[name="transaksi_no"]').prop('readonly', true);
        $('[name="tambah"]').hide();
        $('[name="ubah"]').show();

        $.ajax({
            type: "POST",
            data: {
                id: x
            },
            url: '<?=base_url();?>process/_transaksi.php',
            dataType: 'json',
            success: function(data) {
                $('[name="idtransaksi"]').val(data.idtransaksi);
                $('[name="transaksi_no"]').val(data.transaksi_no);
                $('[name="transaksi_nama"]').val(data.transaksi_nama);
                $('[name="jenis_jasa"]').val(data.jasa_id).trigger('change');
                $('[name="transaksi_jumlah"]').val(data.transaksi_jumlah);
            }
        });
    }
}
</script>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Beranda</h1>
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
                            <th>NO TRX</th>
                            <th>TGL & JAM</th>
                            <th>NAMA PELANGGAN</th>
                            <th>JENIS JASA</th>
                            <th>HARGA SATUAN</th>
                            <th>JUMLAH</th>
                            <th>TOTAL HARGA</th>
                            <th width="50">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $n=1;
                        $query = mysqli_query($con,"SELECT * FROM transaksi x JOIN jasa x1 ON x.jasa_id=x1.idjasa ORDER BY x.transaksi_no DESC")or die(mysqli_error($con));
                        while($row = mysqli_fetch_array($query)):
                        ?>
                        <tr>
                            <td><?= $n++; ?></td>
                            <td><?= $row['transaksi_no']; ?></td>
                            <td><?= date('d-m-Y H:i',$row['transaksi_tgl']); ?></td>
                            <td><?= $row['transaksi_nama']; ?></td>
                            <td><?= $row['jasa_nama']; ?></td>
                            <td><?= 'Rp. '.number_format($row['jasa_harga'],0,'','.'); ?></td>
                            <td><?= $row['transaksi_jumlah']; ?></td>
                            <td><?= 'Rp. '.number_format($row['transaksi_total_harga'],0,'','.'); ?></td>
                            <td>
                                <a href="#transaksiModal" data-toggle="modal"
                                    onclick="submit(<?=$row['idtransaksi'];?>)" class="btn btn-sm btn-circle btn-info"
                                    data-toggle="tooltip" data-placement="top" title="Ubah Data"><i
                                        class="fas fa-edit"></i></a>
                                <a href="<?=base_url();?>process/transaksi.php?act=<?=encrypt('delete');?>&id=<?=encrypt($row['idtransaksi']);?>"
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
            <form action="<?=base_url();?>process/transaksi.php" method="post">
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
                                <label for="transaksi_no">Nomor Transaksi <span class="text-danger">*</span></label>
                                <input type="hidden" name="idtransaksi">
                                <input type="text" class="form-control" id="transaksi_no" name="transaksi_no"
                                    value="<?= noTransaksi(); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="transaksi_nama">Nama Pelanggan <span class="text-danger">*</span></label>
                                <input name="transaksi_nama" id="transaksi_nama" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="jenis_jasa">Jenis Jasa <span class="text-danger">*</span></label>
                                <select name="jenis_jasa" id="jenis_jasa" class="form-control select2"
                                    style="width:100%;" required>
                                    <option value="">-- Pilih Jenis Jasa --</option>
                                    <?= list_jasa(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="transaksi_jumlah">Jumlah <span class="text-danger">*</span></label>
                                <input name="transaksi_jumlah" id="transaksi_jumlah" class="form-control uang" required>
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