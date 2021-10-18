<?php hakAkses(['Admin']) ?>
<script>
function submit(x) {
    if (x == 'add') {
        $('[name="username"]').val("");
        $('[name="nama"]').val("");
        $('[name="level"]').val("");
        $('#penggunaModal .modal-title').html('Add User');
        $('[name="username"]').prop('readonly', false);
        $('[name="password"]').prop('required', true);
        $('#passwordHelp').hide();
        $('[name="ubah"]').hide();
        $('[name="tambah"]').show();
    } else {
        $('#penggunaModal .modal-title').html('Edit User');
        $('[name="username"]').prop('readonly', true);
        $('[name="password"]').prop('required', false);
        $('#passwordHelp').show();
        $('[name="tambah"]').hide();
        $('[name="ubah"]').show();

        $.ajax({
            type: "POST",
            data: {
                id: x
            },
            url: '<?=base_url();?>process/view_user.php',
            dataType: 'json',
            success: function(data) {
                $('[name="id"]').val(data.idpengguna);
                $('[name="username"]').val(data.pengguna_username);
                $('[name="nama"]').val(data.pengguna_nama);
                $('[name="level"]').val(data.pengguna_level);
            }
        });
    }
}
</script>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pengguna</h1>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal" data-target="#penggunaModal"
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
                            <th>NAMA LENGKAP</th>
                            <th>USERNAME</th>
                            <th>LEVEL</th>
                            <th width="1%"><center>&nbsp;&nbsp;&nbsp;&nbsp;Action&nbsp;&nbsp;&nbsp;&nbsp;</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $n=1;
                        $query = mysqli_query($con,"SELECT * FROM pengguna ORDER BY idpengguna DESC")or die(mysqli_error($con));
                        while($row = mysqli_fetch_array($query)):
                        ?>
                        <tr>
                            <td><center><?= $n++; ?></center></td>
                            <td><?= $row['pengguna_nama']; ?></td>
                            <td><?= $row['pengguna_username']; ?></td>
                            <td><?= $row['pengguna_level']; ?></td>
                            <td><center>
                                <?php if($row['pengguna_level']!="Admin"): ?>
                                <a href="#penggunaModal" data-toggle="modal" onclick="submit(<?=$row['idpengguna'];?>)"
                                    class="btn btn-sm btn-circle btn-info"><i class="fas fa-edit"></i></a>
                                <a href="<?=base_url();?>process/users.php?act=<?=encrypt('delete');?>&idpengguna=<?=encrypt($row['idpengguna']);?>"
                                    class="btn btn-sm btn-circle btn-danger btn-hapus"><i class="fas fa-trash"></i></a>
                                <?php else: ?>
                                <span class="badge badge-warning">No Action</span>
                                <?php endif; ?></center>
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

<!-- Modal Tambah Pengguna -->
<div class="modal fade" id="penggunaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="<?=base_url();?>process/users.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="hidden" name="id" class="form-control">
                                <input type="text" class="form-control" name="nama" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password"
                                    aria-describedby="passwordHelp">
                                <small id="passwordHelp" class="form-text" style="color:red;">Biarkan kosong
                                    jika tidak ingin merubah password</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Level Akses</label>
                                <select name="level" class="form-control" required>
                                    <option value="User">User Biasa</option>
                                    <option value="Admin">Administrator</option>
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