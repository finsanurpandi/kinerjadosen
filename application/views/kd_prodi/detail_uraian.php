
  <?php
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
        <small>Tahun Akademik <?=$setting['rft_tahun_ajaran']?> Semester <?=getSemester($setting['semester'])?></small>
      </h1>
      <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Penilaian Kinerja Dosen</a></li>
        <li><a href="#"><?=$dosen[0]['nama'].', '.$dosen[0]['jengped']?></a></li>
        <li class="active">Detail</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><?=$dosen[0]['NIDN'].' - '. $dosen[0]['nama'].', '.$dosen[0]['jengped']?></h3>
        </div>
        <div class="box-body">
<!-- conternt here -->
<strong>Kode - Nama Matakuliah</strong>
<p class="text-muted">
<?=$mkul[0]['rft_kode_matakuliah'].' - '.$mkul[0]['rft_nama_matakuliah']?>
</p>

<strong>Kelas</strong>
<p class="text-muted">
<?=$mkul[0]['rft_kelas']?>
</p>

<strong>Jumlah Mahasiswa Mengisi</strong>
<p class="text-muted">
<?=$done.' dari '.$total.' mahasiswa.'?>
</p>
<hr/>
<a href="<?=base_url($this->session->url)?>" class="btn btn-default btn-xs"><i class="fa fa-arrow-left"></i> kembali</a>
<hr/>
<table class="table table-border table-hover">
<thead>
    <tr>
        <th>#</th>
        <th>Uraian Kinerja Dosen</th>
        <th>Score Rata-rata</th>
    </tr>
</thead>
<tbody>
<?php
$total = 0;
$pembagi = 0;
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
        <td><?=$uraian[$j]['uraian']?></td>
        <td><?=$uraian[$j]['avg']?></td>
    </tr>
<?php 
            $total += $uraian[$j]['avg'];
            $pembagi += 1;
            }
    }
?>
    <tr class="success">
        <th colspan="2"><span class="pull-right">Nilai Rata-Rata</span></th>
        <th style="font-size:20px;"><?=round($total/$pembagi, 4)?></th>
    </tr>
<?php
$total = 0;
$pembagi = 0;
}
?>
    
</tbody>
</table>
<hr/>
<a href="<?=base_url($this->session->url)?>" class="btn btn-default btn-xs"><i class="fa fa-arrow-left"></i> kembali</a>

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
    var semester = document.getElementById('semester');

    for (let index = 0; index < semester.options.length; index++) {
        if (semester.options[index].value == "<?=$semester?>") {
            semester.options[index].setAttribute('selected', 'true');
        };
    };
</script>
