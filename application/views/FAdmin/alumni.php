

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data Alumni
        <!-- <small>it all starts here</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url()?>kd_prodi"><i class="fa fa-dashboard"></i> Master Data</a></li>
        <li class="active">Alumni</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Master Data Alumni</h3>
        </div>
        <div class="box-body">
<!-- conternt here -->
<button class="btn btn-primary btn-xs" type="button" data-toggle="modal" data-target="#modalAddAlumni"><i class="fa fa-plus"></i> Tambah Alumni</button>
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
<table id="tbl-data" class="table table-hover ui-corner-tr ui-helper-clearfix">
<thead>
    <tr>
        <th>#</th>
        <th>NPM</th>
        <th>Nama Mahasiswa</th>
        <th>Alamat</th>
        <th>Email</th>
        <th>No Tlp</th>
        <th>Tahun Lulus</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>
</thead>
<tbody>
<?php
$no = 1;
foreach ($alumni as $key => $value) {

?>
<tr>
      <td><?=$no++?></td>
      <td><?=$value['npm']?></td>
      <td><?=$value['nama']?></td>
      <td><?=$value['alamat']?></td>
      <td><?=$value['email']?></td>
      <td><?=$value['no_tlp']?></td>
      <td><?=$value['thn_lulus']?></td>
      <td>
      <?php
      if ($value['kd_status'] == '1') {
          echo "<span class='label label-success'>Bekerja</span>";
      } elseif ($value['kd_status'] == '2') {
        echo "<span class='label label-info'>Wirausaha</span>";
      } elseif ($value['kd_status'] == '3') {
        echo "<span class='label label-warning'>Belum Bekerja</span>";
      } else {
        echo "<span class='label label-danger'>Tidak Bekerja/Berkeluarga</span>";
      }
      ?>
      </td>
      <td>
        <a href="<?=base_url()?>feedbackadmin/detail_alumni/<?=$this->encrypt->encode($value['npm'])?>" class="btn btn-info btn-xs"><i class="fa fa-search"></i> detail</a>
        <button type="button" id="btnEditAlumni" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modalEditAlumni" data-npm="<?=$value['npm']?>"><i class="fa fa-pencil"></i> edit</button>
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
<div class="modal fade modal-primary-custom" tabindex="-1" role="dialog" id="modalAddAlumni">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Data Alumni</h4>
      </div>
      <div class="modal-body">
        <form method="post">
        <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Program Studi</label>
                <input type="hidden" name="kd_prodi" value="<?=$prodi[0]['kd_prodi']?>"/>
                <input type="text" value="<?=$prodi[0]['prodi']?>" class="form-control" readonly/>
            </div>
            <div class="form-group">
                <label>NPM</label>
                <input type="text" name="npm" class="form-control" id="npm-alumni" onchange="check_npm();" required/>
                <div id="status-npm"></div>
            </div>
            <div class="form-group">
                <label>Nama Alumni</label>
                <input type="text" name="nama" class="form-control" required/>
            </div>
            <div class="form-group">
                <label>Alamat Alumni</label>
                <textarea class="form-control" name="alamat_mhs"></textarea>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>No Telepon</label>
                <input type="number" name="no_tlp" class="form-control" required/>
            </div>
            <div class="form-group">
                <label>Email Alumni</label>
                <input type="email" name="email_mhs" class="form-control" required/>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Bulan Lulus</label>
                    <select name="bln_lulus" class="form-control">
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
                <div class="form-group col-md-6">
                    <label>Tahun Lulus</label>
                    <input type="year" name="thn_lulus" class="form-control"/>
                </div>
            </div>
            <div class="form-group">
                <label>Status Sekarang?</label>
                <br/>
                <?php
                foreach ($status as $key => $value) {
                ?>
                    <label class="radio-inline">
                        <input type="radio" name="kd_status" id="radioStatus" value="<?=$value['kd_status']?>"> <?=$value['keterangan']?>
                    </label>
                <?php } ?>
            </div>
            </div>
            </div> <!-- ROW -->

            <div class="data-perusahaan">
            <hr/>
            <div class="form-group">
                <label>Perusahaan Tempat Alumni Bekerja</label>
                <select name="kd_perusahaan" class="form-control select-add-alumni input-sm" style="width:100%;">
                <option></option>
                <?php
                foreach ($perusahaan as $key => $value) {
                ?>
                    <option value="<?=$value['kd_perusahaan']?>"><?=$value['nama_perusahaan']?></option>
                <?php } ?>
                </select>
            </div>
            <p>Tidak menemukan perusahaan yang dicari?
            <button type="button" class="btn btn-link btn-sm btn-perusahaan"><i class="fa fa-plus"></i> Tambah Perusahaan</button>
            </p>

            <div class="tambah-perusahaan">
                <fieldset class="col-md-12">    	
				<legend>Data Perusahaan</legend>
                <div class="form-group has-primary">
                    <label>Nama Perusahaan</label>
                    <input type="text" name="nama_perusahaan" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Alamat Perusahaan</label>
                    <textarea class="form-control" name="alamat_pt"></textarea>
                </div>
                <div class="form-group">
                    <label>Bidang Usaha</label>
                    <input type="text" name="bidang_usaha_pt" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Email Perusahaan</label>
                    <input type="email" name="email_pt" class="form-control"/>
                </div>
                </fieldset>
                <hr/>
            </div>

            <div class="form-group">
                <label>Posisi Pekerjaan</label>
                <input type="text" name="posisi" class="form-control"/>
            </div>

            <div class="form-group">
                <label>Sesuai Dengan Bidang Program Studi?</label>
                <br/>
                    <label class="radio-inline">
                        <input type="radio" name="kesesuaian" id="radioStatus" value="1"> Ya
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="kesesuaian" id="radioStatus" value="0"> Tidak
                    </label>
            </div>

            <div class="row">
            <div class="form-group col-md-6">
                <label>Bulan Mulai Bekerja</label>
                <select name="bulan_bekerja" class="form-control addFormBulan">
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
            <div class="form-group col-md-6">
                <label>Tahun Mulai Pekerjaan</label>
                <input type="year" name="tahun_bekerja" class="form-control addFormTahun"/>
            </div>
            </div> <!-- Row -->
            </div> <!-- Data Perusahaan -->

            <div class="data-wirausaha">
            <hr/>
            <div class="form-group">
                <label>Nama Tempat Usaha</label>
                <input type="text" name="nama_tempat_usaha" class="form-control addFormPosisi"/>
            </div>

            <div class="form-group">
                <label>Bidang Usaha</label>
                <input type="text" name="bidang_usaha_wirausaha" class="form-control addFormPosisi"/>
            </div>

            <div class="row">
            <div class="form-group col-md-6">
                <label>Bulan Mulai Wirausaha</label>
                <select name="bulan_wirausaha" class="form-control addFormBulan">
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
            <div class="form-group col-md-6">
                <label>Tahun Mulai Pekerjaan</label>
                <input type="year" name="tahun_wirausaha" class="form-control addFormTahun"/>
            </div>
            </div> <!-- Row -->
            </div> <!-- Data Wirausaha -->
      </div>
      <div class="modal-footer">
        <input type="reset" class="btn btn-default btn-xs" data-dismiss="modal" value="Close">
        <input type="submit" class="btn btn-primary btn-xs" name="addAlumni" value="Submit"/>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- EDIT MODAL -->
<div class="modal fade modal-success-custom" tabindex="-1" role="dialog" id="modalEditAlumni">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Ubah Data Alumni</h4>
      </div>
      <div class="modal-body">
        <form method="post">
            <div class="form-group">
                <label>NPM</label>
                <input type="text" name="npm" class="form-control" id="alumniEditNpm" readonly/>
            </div>
            <div class="form-group">
                <label>Nama Alumni</label>
                <input type="text" name="nama" class="form-control" id="alumniEditNama" required/>
            </div>
            <div class="form-group">
                <label>Alamat Alumni</label>
                <textarea class="form-control" name="alamat_mhs" id="alumniEditAlamat"></textarea>
            </div>
            <div class="form-group">
                <label>No Telepon</label>
                <input type="number" name="no_tlp" class="form-control" id="alumniEditTlp" required/>
            </div>
            <div class="form-group">
                <label>Email Alumni</label>
                <input type="email" name="email_mhs" class="form-control" id="alumniEditEmail" required/>
            </div>
            <div class="form-group">
                <label>Tahun Lulus</label>
                <input type="text" name="thn_lulus" class="form-control" id="alumniEditTahun" required/>
            </div>
            <div class="form-group">
                <label>Bekerja di Perusahaan</label>
                <select name="kd_perusahaan" class="form-control" id="alumniEditPt" style="width:100%;">
                <?php
                foreach ($perusahaan as $key => $value) {
                ?>
                    <option value="<?=$value['kd_perusahaan']?>"><?=$value['nama_perusahaan']?></option>
                <?php } ?>
                </select>
            </div>
            <p>Tidak menemukan perusahaan yang dicari?
            <button type="button" class="btn btn-link btn-sm btn-perusahaan"><i class="fa fa-plus"></i> Tambah Perusahaan</button>
            </p>
            <div class="tambah-perusahaan">
            <fieldset class="col-md-12">    	
					<legend>Data Perusahaan</legend>
                <div class="form-group has-primary">
                    <label>Nama Perusahaan</label>
                    <input type="text" name="nama_perusahaan" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Alamat Perusahaan</label>
                    <textarea class="form-control" name="alamat_pt"></textarea>
                </div>
                <div class="form-group">
                    <label>Bidang Usaha</label>
                    <input type="text" name="bidang_usaha" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Email Perusahaan</label>
                    <input type="email" name="email_pt" class="form-control"/>
                </div>
                <hr/>
                <fieldset>
            </div>

            <div class="form-group">
                <label>Posisi Pekerjaan</label>
                <input type="text" name="posisi" class="form-control" id="alumniEditPosisi" required/>
            </div>

            <div class="row">
            <div class="form-group col-md-6">
                <label>Bulan Mulai Bekerja</label>
                <select name="bulan_bekerja" id="alumniEditBulan" class="form-control" required>
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
            <div class="form-group col-md-6">
                <label>Tahun Mulai Pekerjaan</label>
                <input type="year" name="tahun_bekerja" class="form-control" id="alumniEditTahunBekerja" required/>
            </div>
            </div>
      </div>
      <div class="modal-footer">
        <input type="reset" class="btn btn-default btn-xs" data-dismiss="modal" value="Close">
        <input type="submit" class="btn btn-success btn-xs" name="editAlumni" value="Submit"/>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



