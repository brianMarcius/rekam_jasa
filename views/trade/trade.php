<?php hakAkses(['Admin','User']); date_default_timezone_set("Asia/Jakarta"); ?>
<script>
function submit(x, view = 0) {
    if (x == 'add') {
        $('[name="tradeno"]').val("<?=noTrade();?>");
        $('[name="idcust"]').val("").trigger('change');
        $('[name="paymentdate"]').val("");
        $('[name="method"]').val("").trigger('change');
        $('[name="idjasa"]').val("").trigger('change');
        $('[name="totaltrade"]').val("");
        $('[name="totalharga"]').val("");
        $('#transaksiModal .modal-title').html('Tambah Transaksi');
        $('[name="tradeno"]').prop('readonly', false);
        $('[name="ubah"]').hide();
        $('[name="tambah"]').show();
    } else {
        $('#transaksiModal .modal-title').html('Edit Transaksi');
        $('[name="tradeno"]').prop('readonly', false);
        $('[name="tambah"]').hide();
        $('[name="ubah"]').show();

        $.ajax({
            type: "POST",
            data: {
                id: x
            },
            url: '<?=base_url();?>process/view_trade.php',
            dataType: 'json',
            success: function(data) {
                $('[name="idtrade"]').val(data.idtrade);
                $('[name="tradeno"]').val(data.tradeno);
                $('[name="idcust"]').val(data.idcust).trigger('change');
                $('[name="idjasa"]').val(data.idjasa).trigger('change');
                $('[name="paymentdate"]').val(data.paymentdate);
                $('[name="method"]').val(data.method).trigger('change');
                $('[name="totaltrade"]').val(data.totaltrade);
                $('[name="totalharga"]').val(data.totalharga);
                //setTimeout(
                //    function() 
                //    {
                //        $('[name="idcust"]').val(data.idcust).trigger('change');
                //    }, 500);

                if (view) {
                    $('#viewModal .modal-title').html('Detail Customer');
                    $('#view_tradeno').html(data.cust_no);
                    $('#view_customer_name').html(data.nama);
                    $('#view_jasa').html(data.nama_jasa);
                    $('#view_biaya').html(data.biaya);
                    $('#view_totaltrade').html(data.totaltrade);
                    $('#view_totalharga').html(data.totalharga);
                    $('#view_expired_date').html(data.exp);
                    $('#view_paymentdate').html(data.paymentdate);
                    $('#view_method').html(data.method);
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
        <h1 class="h3 mb-0 text-gray-800">Transaksi</h1>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal" data-target="#transaksiModal"
                onclick="submit('add')">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah Transaksi</span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="20">NO</th>
                            <th>Customer Name</th>
                            <th>Payment Date</th>
                            <th>Jumlah Bulan</th>
                            <th>Total Pembayaran</th>

                            <th width="1%"><center>&nbsp;&nbsp;&nbsp;&nbsp;Action&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $n=1;
                        $query = mysqli_query($con,"SELECT * FROM trade t, customer c WHERE t.idcust=c.idcust and t.data_status='Enable' ORDER BY t.tradeno DESC") or die(mysqli_error($con));
                        while($row = mysqli_fetch_array($query)):
                        ?>
                        <tr>
                        <td><center><?= $n++; ?></center></td>
                            <td><?= $row['nama']; ?></td>
                            <td><?= $row['paymentdate']; ?></td>
                            <td><?= $row['totaltrade'];?> Bulan</td>
                            <td><?= 'Rp. '.number_format($row['totalharga'],0,'','.'); ?></td>
                            <td><center>
                                <a href="#viewModal" data-toggle="modal"
                                    onclick="submit(<?=$row['idtrade'];?>,'1')" class="btn btn-sm btn-circle btn-warning"
                                    data-toggle="tooltip" data-placement="top" title="View Data"><i
                                        class="fas fa-eye"></i></a>
                                <a href="#transaksiModal" data-toggle="modal"
                                    onclick="submit(<?=$row['idtrade'];?>)" class="btn btn-sm btn-circle btn-info"
                                    data-toggle="tooltip" data-placement="top" title="Ubah Data"><i
                                        class="fas fa-edit"></i></a>
                                <a href="<?=base_url();?>process/trade.php?act=<?=encrypt('delete');?>&idtrade=<?=encrypt($row['idtrade']);?>"
                                    class="btn btn-sm btn-circle btn-danger btn-hapus" data-toggle="tooltip"
                                    data-placement="top" title="Hapus Data"><i class="fas fa-trash"></i></a></center>
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
            <form action="<?=base_url();?>process/trade.php" method="post">
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
                                <label for="tradeno">No. Transaksi <span class="text-danger">*</span></label>
                                <input type="hidden" name="tradeno">
                                <input type="text" class="form-control" id="tradeno" name="tradeno"
                                    value="<?= noTrade(); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="idjasa">Input Jasa <span class="text-danger">*</span></label>
                                <select name="idjasa" id="ididjasacat" class="form-control select2"
                                    style="width:100%;" required>
                                    <option value="">-- Pilih Jasa --</option>
                                    <?= list_jj(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="idcust">Select Customer <span class="text-danger">*</span></label>
                                <select name="idcust" id="idcust" class="form-control select2"
                                    style="width:100%;" required>
                                    <option value="">-- Select Customer --</option>
                                    <?= list_cust(); ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Metode Pembayaran <span class="text-danger">*</span></label>
                                <select name="method" class="form-control" required>
                                    <option value="MANDIRI-KANTOR">MANDIRI - KANTOR</option>
                                    <option value="MANDIRI-PRIBADI">MANDIRI - PRIBADI</option>
                                    <option value="BCA-KANTOR">BCA - KANTOR</option>
                                    <option value="BCA-PRIBADI">BCA - PRIBADI</option>
                                    <option value="BRI-KANTOR">BRI - KANTOR</option>
                                    <option value="BRI-PRIBADI">BRI - PRIBADI</option>
                                    <option value="CASH">CASH/TUNAI</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Bulan Yang Dibayarkan <span class="text-danger">*</span></label>
                                <select name="totaltrade" class="form-control" required>
                                    <option value="1">1 Bulan</option>
                                    <option value="2">2 Bulan</option>
                                    <option value="3">3 Bulan</option>
                                    <option value="4">4 Bulan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="paymentdate">Select Date <span class="text-danger">*</span></label>
                                <input name="paymentdate" id="paymentdate" type="date" class="form-control" required>
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
                                        <td style="width:10%; padding:5px"><label class="font-weight-bold" for="view_customer_name">Customer Name</label></td>
                                        <td style="width:3%; padding:5px">:</td>
                                        <td style="width:25%; padding:5px"><span id="view_customer_name"></span></td>
                                        <td style="width:3%; padding:5px"> </td>
                                        <td style="width:10%; padding:5px"><label class="font-weight-bold" for="view_paymentdate">Payment Date </label></td>
                                        <td style="width:3%; padding:5px">:</td>
                                        <td style="width:25%; padding:5px"><span id="view_paymentdate"></span></td>
                                    </tr>
                                    <tr><td style="width:10%; padding:5px"><label class="font-weight-bold" for="view_jasa">Jasa </label></td>
                                        <td style="width:3%; padding:5px">:</td>
                                        <td style="width:25%; padding:5px"><span id="view_jasa"></span>&nbsp;&nbsp;-&nbsp;
                                        <label for="view_biaya">Rp. </label>
                                        <span id="view_biaya"></span></td>
                                        <td style="width:3%; padding:5px"> </td>
                                        <td style="width:10%; padding:5px"><label class="font-weight-bold" for="view_expired_date">New Expired Date </label></td>
                                        <td style="width:3%; padding:5px">:</td>
                                        <td style="width:25%; padding:5px"><span id="view_expired_date"></span></td>
                                    </tr>
                                    <tr>
                                        <td style="width:10%; padding:5px"><label class="font-weight-bold" for="view_totaltrade">Jumlah Bulan </label></td>
                                        <td style="width:3%; padding:5px">:</td>
                                        <td style="width:25%; padding:5px"><span id="view_totaltrade"></span> Bulan</td>
                                        <td style="width:3%; padding:5px"> </td>
                                        <td style="width:10%; padding:5px"><label class="font-weight-bold" for="view_totalharga">Jumlah Bayar </label></td>
                                        <td style="width:3%; padding:5px">:</td>
                                        <td style="width:25%; padding:5px">Rp. <span id="view_totalharga"></span></td>
                                    </tr>
                                    <tr>
                                        <td style="width:10%; padding:5px"><label class="font-weight-bold" for="view_tradeno">No Transaksi </label></td>
                                        <td style="width:3%; padding:5px">:</td>
                                        <td style="width:25%; padding:5px"><span id="view_tradeno"></span></td>
                                        <td style="width:3%; padding:5px"> </td>
                                        <td style="width:10%; padding:5px"><label class="font-weight-bold" for="view_method">Metode </label></td>
                                        <td style="width:3%; padding:5px">:</td>
                                        <td style="width:25%; padding:5px"><span id="view_method"></span></td>
                                    </tr>
                                    <tr>
                                        <td style="width:10%; padding:5px"><label class="font-weight-bold" for="view_service_status">Status </label></td>
                                        <td style="width:3%; padding:5px">:</td>
                                        <td style="width:25%; padding:5px"><span class="badge badge-success" id="view_service_status"></span></td>
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