

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Penilaian Kinerja Dosen
        <!-- <small>it all starts here</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url()?>kd_prodi"><i class="fa fa-dashboard"></i> Kategori Penilaian</a></li>
        <li class="active">Penilaian</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Kategori Penilaian</h3>
        </div>
        <div class="box-body">
<!-- conternt here -->
<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#addUraian">
    <i class="fa fa-plus"></i> Tambah
</button>
<hr/>
<table class="table table-border table-hover">
<thead>
    <tr>
        <th>#</th>
        <th>Kategori Penilaian</th>
        <th>Urutan</th>
        <th>Aksi</th>
    </tr>
</thead>
<tbody>
<?php
$no = 1;
foreach ($kategori as $key => $value) {

?>
<tr>
        <td><?=$no++?></td>
        <td><?=$value['aspek_penilaian']?></td>
        <td>
        <form method="post">
        <?php
        if ($value['urutan'] == $first) {
            ?>
            <button name="down" class="btn btn-link" value="true"><i class="fa fa-arrow-down"></i></button>
            <button type="button" name="up" class="btn btn-link" value="true" disabled="true"><i class="fa fa-arrow-up"></i></button>
            <?php
        } elseif ($value['urutan'] == $last) {
            ?> 
            <button type="button" name="down" class="btn btn-link" value="true" disabled="true"><i class="fa fa-arrow-down"></i></button>
            <button name="up" class="btn btn-link" value="true"><i class="fa fa-arrow-up"></i></button>
            <?php
        } else {
        ?>
            <button name="down" class="btn btn-link" value="true"><i class="fa fa-arrow-down"></i></button>
            <button name="up" class="btn btn-link" value="true"><i class="fa fa-arrow-up"></i></button>
        <?php
        }

        ?>
            <input type="hidden" name="urutan" value="<?=$value['urutan']?>"/>
            <input type="hidden" name="aspek_penilaian" value="<?=$value['aspek_penilaian']?>"/>
        </form>
        </td>
        <td>
                <button type="button" class="btn btn-success btn-xs" id="btn-edit-kategori"
                data-toggle="modal" 
                data-target="#editKategori"
                data-kategori="<?=$value['aspek_penilaian']?>"
                data-urutan="<?=$value['urutan']?>"
                >
                    <i class="fa fa-pencil"></i>
                </button>
                <button type="button" class="btn btn-danger btn-xs" id="btn-hapus-kategori"
                data-toggle="modal" 
                data-target="#hapusKategori"
                data-kategori="<?=$value['aspek_penilaian']?>"
                data-urutan="<?=$value['urutan']?>"
                >
                    <i class="fa fa-trash"></i>
                </button>
        </td>
    </tr>
<?php 
            
}
?>
    
</tbody>
</table>

<!-- end content           -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<!-- MODAL -->
<!-- Add Uraian -->
<div class="modal fade modal-primary-custom" tabindex="-1" role="dialog" id="addUraian">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Uraian</h4>
      </div>
      <div class="modal-body">
        <form method="post">
            <div class="form-group">
                <label>Kategori</label>
                <input type="text" class="form-control" name="aspek_penilaian" required/>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
        <button class="btn btn-primary btn-sm" name="addKategori">Tambah</button>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Edit Uraian -->
<div class="modal fade modal-success-custom" tabindex="-1" role="dialog" id="editKategori">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Uraian</h4>
      </div>
      <div class="modal-body">
        <form method="post">
            <div class="form-group">
                <label>Kategori</label>
                <input type="text" class="form-control" name="aspek_penilaian" id="kategoriEdit" required/>
                <input type="hidden" name="urutan" id="urutanEdit"/>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
        <button class="btn btn-success btn-sm" name="saveEdit">Edit</button>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Hapus Uraian -->
<div class="modal fade modal-danger-custom" tabindex="-1" role="dialog" id="hapusKategori">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Hapus Kategori</h4>
      </div>
      <div class="modal-body">
        <div class="output"></div>
      </div>
      <div class="modal-footer">
        <form method="post">
        <input type="hidden" class="form-control" name="urutan" id="urutanHapus"/>
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
        <button class="btn btn-danger btn-sm" name="deleteKategori">Hapus</button>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="<?=base_url()?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<script>
$(document).ready(function(){

    $(document).on('click', '#btn-edit-kategori', function(e){
        var kategori = $(this).data('kategori');
        var urutan = $(this).data('urutan');
    
        $('#kategoriEdit').val(kategori);
        $('#urutanEdit').val(urutan);

    });

    $(document).on('click', '#btn-hapus-kategori', function(e){
        var kategori = $(this).data('kategori');
        var urutan = $(this).data('urutan');

        $('#urutanHapus').val(urutan);


        $('.output').html(
            "Apakah anda yakin akan menghapus data dengan kategori = "+
            "<strong>"+kategori+"</strong>"
        );
    });
    
});
</script>
