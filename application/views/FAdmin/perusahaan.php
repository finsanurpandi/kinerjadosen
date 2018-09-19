

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data Perusahaan
        <!-- <small>it all starts here</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> Master Data</a></li>
        <li class="active">Perusahaan</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Master Data Perusahaan</h3>
        </div>
        <div class="box-body">
<!-- conternt here -->
<button class="btn btn-primary btn-xs" type="button" data-toggle="modal" data-target="#modalAddPerusahaan"><i class="fa fa-plus"></i> Tambah Perusahaan</button>
<?php
  if (@$this->session->flashdata('success') == true) {
?>
    <br/><br/>
    <div class="alert alert-success">Data berhasil ditambahkan!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <br/>
    </div>

<?php
  } elseif (@$this->session->flashdata('warning') == true) {
?>
    <br/><br/>
    <div class="alert alert-warning">Data berhasil diubah!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <br/>
    </div>
<?php
  } elseif (@$this->session->flashdata('danger') == true) {
?>
    <br/><br/>
    <div class="alert alert-danger">Data berhasil dihapus!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <br/>
    </div>
<?php
  }
?> 
<hr/>
<table id="tbl-hello" class="table table-hover ui-corner-tr ui-helper-clearfix">
<thead>
    <tr>
        <th>#</th>
        <th>Nama Perusahaan</th>
        <th>Alamat</th>
        <th>Bidang Usaha</th>
        <th>Email</th>
        <th>Aksi</th>
    </tr>
</thead>
<tbody>
<?php
$no = 1;
foreach ($perusahaan as $key => $value) {
?>
<tr>
      <td><?=$no++?></td>
      <td><?=$value['nama_perusahaan']?></td>
      <td><?=$value['alamat']?></td>
      <td><?=$value['bidang_usaha']?></td>
      <td><?=$value['email']?></td>
      <td>
        <a href="<?=base_url()?>feedbackadmin/detail_perusahaan/<?=$this->encrypt->encode($value['kd_perusahaan'])?>" class="btn btn-info btn-xs"><i class="fa fa-search"></i> detail</a>
        <button type="button" id="btnEditPerusahaan" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modalEditPerusahaan" data-perusahaan="<?=$value['kd_perusahaan']?>"><i class="fa fa-pencil"></i> edit</button>
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
<!-- Add Perusahaan -->
<div class="modal fade modal-primary-custom" tabindex="-1" role="dialog" id="modalAddPerusahaan">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Data Perusahaan</h4>
      </div>
      <div class="modal-body">
        <form method="post">
          <div class="form-group has-primary">
            <label>Nama Perusahaan</label>
            <input type="text" name="nama_perusahaan" class="form-control" required/>      
          </div>
          <div class="form-group">
            <label>Alamat Perusahaan</label>
            <textarea class="form-control" name="alamat" required></textarea>
          </div>
          <div class="form-group">
            <label>Bidang Usaha</label>
            <input type="text" name="bidang_usaha" class="form-control" required/>
          </div>
          <div class="form-group">
            <label>Email Perusahaan</label>
            <input type="email" name="email" class="form-control"/>
          </div>    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-xs" data-dismiss="modal">Tutup</button>
        <button class="btn btn-primary btn-xs" name="addPerusahaan">Tambah</button>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Edit Perusahaan -->
<div class="modal fade modal-success-custom" tabindex="-1" role="dialog" id="modalEditPerusahaan">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Data Perusahaan</h4>
      </div>
      <div class="modal-body">
        <form method="post">
          <div class="form-group has-primary">
            <label>Nama Perusahaan</label>
            <input type="text" name="nama_perusahaan" class="form-control" id="ptEditNama"/>      
          </div>
          <div class="form-group">
            <label>Alamat Perusahaan</label>
            <textarea class="form-control" name="alamat" id="ptEditAlamat"></textarea>
          </div>
          <div class="form-group">
            <label>Bidang Usaha</label>
            <input type="text" name="bidang_usaha" class="form-control" id="ptEditBidangUsaha"/>
          </div>
          <div class="form-group">
            <label>Email Perusahaan</label>
            <input type="email" name="email" class="form-control" id="ptEditEmail"/>
          </div>    
      </div>
      <div class="modal-footer">
        <input type="hidden" name="kd_perusahaan" class="form-control" id="ptEditKode"/>
        <button type="button" class="btn btn-default btn-xs" data-dismiss="modal">Tutup</button>
        <button class="btn btn-success btn-xs" name="editPerusahaan">Ubah</button>
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
        <button type="button" class="btn btn-default btn-xs" data-dismiss="modal">Tutup</button>
        <button class="btn btn-danger btn-xs" name="deleteKategori">Hapus</button>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

