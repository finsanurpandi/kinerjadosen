

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Penilaian Kinerja Dosen
        <!-- <small>it all starts here</small> -->
      </h1>
      <ol class="breadcrumb">
        <li class="active"><i class="fa fa-dashboard"></i> Uraian Penilaian</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Uraian Penilaian</h3>
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
        <th>Uraian Kinerja Dosen</th>
        <th>Aksi</th>
    </tr>
</thead>
<tbody>
<?php

$no = 1;
for ($i=0; $i < count($kategori); $i++) { 
?>

    <tr class="info">
        <th colspan="3"><?=$kategori[$i]['aspek_penilaian']?></th>
    </tr>

<?php
        for ($j=0; $j < count($uraian); $j++) { 
            if ($uraian[$j]['aspek_penilaian'] == $kategori[$i]['aspek_penilaian']) {
?>

<tr>
        <td><?=$no++?></td>
        <td><?=$uraian[$j]['uraian']?></td>
        <td>
                <button type="button" class="btn btn-success btn-xs" id="btn-edit-uraian"
                data-toggle="modal" 
                data-target="#editUraian"
                data-kode="<?=$uraian[$j]['kode_kinerja']?>"
                data-kategori="<?=$uraian[$j]['aspek_penilaian']?>"
                data-uraian="<?=$uraian[$j]['uraian']?>"
                >
                    <i class="fa fa-pencil"></i>
                </button>
                <button type="button" class="btn btn-danger btn-xs" id="btn-hapus-uraian"
                data-toggle="modal" 
                data-target="#hapusUraian"
                data-kode="<?=$uraian[$j]['kode_kinerja']?>"
                data-kategori="<?=$uraian[$j]['aspek_penilaian']?>"
                data-uraian="<?=$uraian[$j]['uraian']?>"
                >
                    <i class="fa fa-trash"></i>
                </button>
        </td>
    </tr>
<?php 
            }
    }
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
                <select name="aspek_penilaian" class="form-control" required>
                <option></option>
                <?php
                    foreach ($kategori as $key => $value) {
                        echo "<option value='".$value['aspek_penilaian']."'>".$value['aspek_penilaian']."</option>";
                    }
                ?>
                </select>
            </div>
            <div class="form-group">
                <label>Uraian Kinerja Dosen</label>
                <input type="text" class="form-control" name="uraian" required/>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
        <button class="btn btn-primary btn-sm" name="addUraian">Tambah</button>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Edit Uraian -->
<div class="modal fade modal-success-custom" tabindex="-1" role="dialog" id="editUraian">
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
                <select name="aspek_penilaian" class="form-control" id="kategori">
                <?php
                    foreach ($kategori as $key => $value) {
                        echo "<option value='".$value['aspek_penilaian']."'>".$value['aspek_penilaian']."</option>";
                    }
                ?>
                </select>
            </div>
            <div class="form-group">
                <label>Uraian Kinerja Dosen</label>
                <input type="text" class="form-control" name="uraian" id="uraian"/>
                <input type="hidden" class="form-control" name="kode_kinerja" id="kode"/>
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
<div class="modal fade modal-danger-custom" tabindex="-1" role="dialog" id="hapusUraian">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Hapus Uraian</h4>
      </div>
      <div class="modal-body">
        <div class="output"></div>
      </div>
      <div class="modal-footer">
        <form method="post">
        <input type="hidden" class="form-control" name="kode_kinerja" id="hapusKode"/>
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
        <button class="btn btn-danger btn-sm" name="deleteUraian">Hapus</button>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="<?=base_url()?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<script>
$(document).ready(function(){

    $(document).on('click', '#btn-edit-uraian', function(e){
        var kode = $(this).data('kode');
        var kategori = $(this).data('kategori');
        var uraian = $(this).data('uraian');
    
        $('#uraian').val(uraian);
        $('#kode').val(kode);

        $('#kategori option').filter(function(){
            return ($(this).val() == $('#kategori').val(kategori));
        }).prop('selected', true);
    });

    $(document).on('click', '#btn-hapus-uraian', function(e){
        var kode = $(this).data('kode');
        var kategori = $(this).data('kategori');
        var uraian = $(this).data('uraian');
    
        $('#hapusKode').val(kode);

        $('.output').html(
            "Apakah anda yakin akan menghapus data dengan detail seperti di bawah ini?"+
            "<ul>"+
            "<li><strong>Kategori:</strong> "+kategori+"</li>"+
            "<li><strong>Uraian:</strong> "+uraian+"</li>"+
            "</ul>"
        );
    });
    
});
</script>
