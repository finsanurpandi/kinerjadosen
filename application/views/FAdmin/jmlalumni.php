<?php

function getMonth($month)
{
    switch ($month) {
        case 1:
            echo "Januari";
            break;
        case 2:
            echo "Februari";
            break;
        case 3:
            echo "Maret";
            break;
        case 4:
            echo "April";
            break;
        case 5:
            echo "Mei";
            break;
        case 6:
            echo "Juni";
            break;
        case 7:
            echo "Juli";
            break;
        case 8:
            echo "Agustus";
            break;
        case 9:
            echo "September";
            break;
        case 10:
            echo "Oktober";
            break;
        case 11:
            echo "November";
            break;
        case 12:
            echo "Desember";
            break;
        default:
            echo "";
            break;
    }
}

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data Jumlah Alumni
        <!-- <small>it all starts here</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url()?>kd_prodi"><i class="fa fa-dashboard"></i> Master Data</a></li>
        <li class="active">Jumlah Alumni</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Master Data Jumlah Alumni</h3>
        </div>
        <div class="box-body">
<!-- conternt here -->
<button class="btn btn-primary btn-xs" type="button" data-toggle="modal" data-target="#modalEditJmlAlumni"><i class="fa fa-plus"></i> Tambah Data</button>
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
<div class="table-responsive">
<table id="tbl-hello" class="table table-hover ui-corner-tr ui-helper-clearfix">
<thead>
    <tr>
        <th>#</th>
        <th>Tahun Akademik</th>
        <th>Bulan</th>
        <th>Periode</th>
        <th>Jumlah</th>
        <th>Aksi</th>
    </tr>
</thead>
<tbody>
<?php
$no = 1;
foreach ($jmlalumni as $key => $value) {

?>
<tr>
      <td><?=$no++?></td>
      <td><?=$value['tahun_akademik']?></td>
      <td><?=getMonth($value['bulan'])?></td>
      <td><?=$value['periode']?></td>
      <td><?=$value['jumlah']?></td>
      <td>
        <button type="button" id="btnEditJmlAlumni" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modalEditJmlAlumni" data-npm="<?=$value['id']?>"><i class="fa fa-pencil"></i> edit</button>
      </td>
</tr>
<?php 
            
}
?>
    
</tbody>
</table>



</div>
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
<!-- ADD MODAL -->
<div class="modal fade modal-primary-custom" tabindex="-1" role="dialog" id="modalEditJmlAlumni">
<div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Data Jumlah Perusahaan</h4>
      </div>
      <div class="modal-body">
        <form method="post">
          <div class="form-group has-primary">
            <label>Tahun Akademik</label>
            <input type="text" name="tahun_akademik" class="form-control" placeholder="2015/2016" required/>      
          </div>
          <div class="form-group">
            <label>Bulan</label>
            <select name="bulan" class="form-control" required>
                <option></option>
                <option value="1">Januari</option>
                <option value="2">Februari</option>
                <option value="3">Maret</option>
                <option value="4">April</option>
                <option value="5">Mei</option>
                <option value="6">Juni</option>
                <option value="7">Juli</option>
                <option value="8">Agustus</option>
                <option value="9">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>
          </div>
          <div class="form-group">
            <label>Periode</label>
            <select name="periode" class="form-control" required>
                <option></option>
                <option value="ganjil">Ganjil</option>
                <option value="genap">Genap</option>
            </select>
          </div>
          <div class="form-group">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control"/>
          </div>    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-xs" data-dismiss="modal">Tutup</button>
        <button class="btn btn-primary btn-xs" name="addJmlAlumni">Tambah</button>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



