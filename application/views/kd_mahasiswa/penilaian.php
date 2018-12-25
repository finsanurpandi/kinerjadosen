
  <?php
    // $nilai = array(1,2,3,4,5);
    // $nilai = array(1 => "Sangat Kurang",2 => "Kurang",3 => "Cukup",4 => "Baik",5 => "Sangat Baik");
    $nilai = array(5 => "Sangat Baik", 4 => "Baik", 3 => "Cukup", 2 => "Kurang", 1 => "Sangat Kurang");

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
        <li><a href="<?=base_url()?>mahasiswa"><i class="fa fa-dashboard"></i> Penilaian Kinerja Dosen</a></li>
        <li class="active">Penilaian</li>
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
<strong>NPM - NAMA</strong>
<p class="text-muted">
<?=$mhs['npm'].' - '.$mhs['nama']?>
</p>

<strong>Kode - Matkul</strong>
<p class="text-muted">
<?=$mkul['rft_kode_matakuliah'].' - '.$mkul['rft_nama_matakuliah']?>
</p>

<strong>NIDN - Nama Dosen</strong>
<p class="text-muted">
<?=$dosen['NIDN'].' - '.$dosen['nama'].', '.$dosen['jengped']?>
</p>

<hr/>
<?php if ($check == 0) { ?>
<p class="text-muted"><em>
Penilaian ini bersifat tertutup, identitas anda akan dirahasiakan. Isi penilaian sesuai dengan kenyataan.
</em></p>
<hr/>

<form method="post">
<div class="table-responsive">
<table class="table table-border table-hover">
<thead>
    <tr>
        <th>#</th>
        <th>Uraian Kinerja Dosen</th>
        <th>Penilaian</th>
    </tr>
</thead>
<tbody>
<?php

$no = 1;
for ($i=0; $i < count($aspek); $i++) { 
?>

    <tr class="info">
        <th colspan="3"><?=$aspek[$i]['aspek_penilaian']?></th>
    </tr>

<?php
        for ($j=0; $j < count($uraian); $j++) { 
            if ($uraian[$j]['aspek_penilaian'] == $aspek[$i]['aspek_penilaian']) {
?>

<tr>
        <td><?=$no++?></td>
        <td><?=$uraian[$j]['uraian']?>
        <input type="hidden" name="kode_kinerja[<?=$j?>]" value="<?=$uraian[$j]['kode_kinerja']?>"/></td>
        <td>
<?php
            
    foreach ($nilai as $row => $vlue) {
?>
            <label class="radio-inline">
                <input type="radio" name="nilai[<?=$j?>]" value="<?=$row?>" required><?=$vlue?>
            </label>
<?php } ?>
        </td>
    </tr>
<?php 
            }
    }
}
?>
    <!-- <tr>
        <td colspan="3">
        <div class="form-group">
            <label>Catatan</label>
            <textarea name="catatan" class="form-control" rows="3" id="catatan"></textarea>
            <div>Maksimal 250 kata. <span id="out"></span></div>
        </div>
        </td>
    </tr> -->
    <tr>
        
        <td colspan="3"><div class="text-center"><button class="btn btn-primary btn-xs" name="sbmtPenilaian">submit</button></div></td>
    </tr>
    
</tbody>
</table>
</div>
</form>
<?php
} else {
?>
<div class="alert alert-success">Terima kasih telah mengisi penilaian untuk matakuliah <strong><?=$mkul['rft_nama_matakuliah']?></strong> yang diampu oleh <strong><?=$dosen['nama'].', '.$dosen['jengped']?></strong></div>
<?php } ?>
<a href="<?=base_url()?>mahasiswa" class="btn btn-default btn-xs"><i class="fa fa-arrow-left"></i> kembali</a>
<!-- end content           -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<script>
function WordCount(str) { 
  return str.split(" ").length;
}

document.getElementById('catatan').onkeyup = function(){
		document.getElementById('out').innerHTML = "Sisa " + (11 - WordCount(this.value) + " kata.");
		if (WordCount(this.value) == 11) {
			alert('Max');
		};
	}
</script>
