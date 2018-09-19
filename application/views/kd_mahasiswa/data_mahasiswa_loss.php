
  <?php
    $nilai = array("A", "B", "C", "D", "E");
    function getSemester($str)
    {
        $semester = substr($str, -1);

        if ($semester == 2) {
            return "Genap";
        } else {
            return "Ganjil";
        }
    }

  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Penilaian Kinerja Dosen
        <!-- <small>it all starts here</small> -->
      </h1>
      <ol class="breadcrumb">
        <li class="active"><i class="fa fa-dashboard"></i> Penilaian Kinerja Dosen</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Tahun Akademik <?=$setting['rft_tahun_ajaran']?> Semester <?=getSemester($setting['semester'])?></h3>
        </div>
        <div class="box-body">
<!-- conternt here -->
<form method="post">
  <div class="form-group">
    <label>Npm</label>
    <input type="text" name="npm" class="form-control"/>
    <button class="btn btn-primary">submit</button>
  </div>
</form>
<hr/>
<!-- <h3>Selamat Datang, <?=$mhs['nama']?> !</h3> -->
<strong>Nama</strong>
<p class="text-muted">
<?=$mhs['nama']?>
</p>

<strong>NPM</strong>
<p class="text-muted">
<?=$mhs['npm']?>
</p>

<strong>KELAS</strong>
<p class="text-muted">
<?=$mhs['kelas']?>
</p>

<hr/>

<?php
  if (!empty($kelas[0]['kelas'])) {
?>
<div class="alert alert-info" role="alert">Silahkan pilih kelas berdasarkan matakuliah yang diambil pada semester sebelumnya</div>
<form method="post">
<div class="table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Kode Matakuliah</th>
          <th>Nama Matakuliah</th>
          <th>SKS</th>
          <th>Kelas</th>
        </tr>
      </thead>
      <tbody>
<?php
$no = 1;
$i = 0;
    foreach ($matakuliah as $key => $value) {
      
?>
        <tr>
          <td><?=$no++?></td>
          <td><?=$value['rft_kode_matakuliah']?></td>
          <td><?=$value['rft_nama_matakuliah']?></td>
          <td><?=$value['rft_sks']?></td>
          <td>
          <input type="hidden" name="id[<?=$i?>]" value="<?=$value['id']?>"/>
<?php
            
    foreach ($nilai as $row) {
?>
            <label class="radio-inline">
                <input type="radio" name="kelas[<?=$i?>]" value="<?=$row?>" required><?=$row?>
            </label>
<?php } ?>
          </td>
        </tr>
<?php
$i++;
    }
?>
    <tfoot>
    <tr>
      <td colspan="5">
        <input type="submit" class="btn btn-primary btn-xs" name="addClass" value="submit"/>
      </td>
    </tr>
    </tfoot>
    </tbody>
    </table>
    </div>
<?php
  } else {
?>
<strong>Matakuliah :</strong>
<div class="table-responsive">
<table class="table table-border table-hover">
<thead>
    <tr>
        <th>#</th>
        <th>Kode</th>
        <th>Matakuliah</th>
        <th>Kelas</th>
        <th>Dosen</th>
        <th>Penilaian</th>
    </tr>
</thead>
<tbody>
<?php
$num = 1;
  for ($i=0; $i < count($krs); $i++) { 
?>
    <tr>
        <td><?=$num++?></td>
        <td><?=$krs[$i]['rft_kode_matakuliah']?></td>
        <td><?=$krs[$i]['rft_nama_matakuliah']?></td>
        <td><?=$krs[$i]['rft_kelas']?></td>
        <td><?=$krs[$i]['nama_dosen'].', '.$krs[$i]['jengped']?></td>
        <td>
<?php
        // if ($krs[$i]['kode_matkul'] !== null) {
          if (!empty($krs[$i]['kode_matkul'])) {
          echo "<div class='label label-success'>sudah mengisi</div>";
        } else {
?>
          <a href="<?=base_url()?>mahasiswa/penilaian/<?=$this->encrypt->encode($krs[$i]['rft_npm'])?>/<?=$this->encrypt->encode($krs[$i]['rft_kode_matakuliah'])?>/<?=$this->encrypt->encode($krs[$i]['rft_nidn'])?>/<?=$this->encrypt->encode($krs[$i]['rft_kelas'])?>/<?=$this->encrypt->encode($krs[$i]['rft_kode_jadwal'])?>" class="btn btn-info btn-xs">isi penilaian</a>
<?php   } ?>          
        </td>
        
    </tr>
<?php } ?>
</tbody>

</table>
</div>
</form>

  <?php } ?>
<!-- end content           -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


