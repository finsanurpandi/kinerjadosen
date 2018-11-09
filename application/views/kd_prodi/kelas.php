

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Penilaian Kinerja Dosen
        <!-- <small>it all starts here</small> -->
      </h1>
      <ol class="breadcrumb">
        <li class="active"><i class="fa fa-dashboard"></i> Data Kelas Mahasiswa</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Data Kelas Mahasiswa</h3>
        </div>
        <div class="box-body">
<!-- conternt here -->

<table id="tbl-mhs" class="table table-hover ui-corner-tr ui-helper-clearfix">
<thead>
    <tr>
        <th>#</th>
        <th>NPM</th>
        <th>Nama Mahasiswa</th>
        <th>Angkatan</th>
        <th>Kelas</th>
        <th>Aksi</th>
    </tr>
</thead>
<tbody>
<?php
$no = 1;
foreach ($mhs as $key => $value) {

?>
<tr>
      <td><?=$no++?></td>
      <td><?=$value['rft_npm']?></td>
      <td><?=$value['nama']?></td>
      <td><?=$value['angkatan']?></td>
      <td><?=$value['kelas']?></td>
      <td>
        <a href="<?=base_url()?>prodi/detail_kelas/<?=$this->encrypt->encode($value['rft_npm'])?>" class="btn btn-success btn-xs">detail</a>
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
