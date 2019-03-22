
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
          <h3 class="box-title">Tahun Akademik <?=$setting['rft_tahun_ajaran']?> Semester <?=getSemester($setting['kd_semester'])?></h3>
        </div>
        <div class="box-body">
        
<!-- conternt here -->
<form method="post" class="form-inline">
    <div class="form-group">
        <label for="exampleInputName2">Semester</label>
        <select name="semester" id="semester" class="form-control" onchange="this.form.submit();">
            <?php
                foreach ($allSemester as $key => $value) {
                    echo "<option value=".$value['rft_semester'].">".$value['rft_semester']."</option>";        
                }
            ?>
        </select>
  </div>
</form>
<hr/>
<a href="<?=base_url()?>Cetak/cetak_rekap_semua_dosen/<?=$semester.'/'.$this->session->kdprodi.'/'.$this->encrypt->encode($setting['rft_tahun_ajaran']).'/'.getSemester($setting['kd_semester'])?>" target="_blank" class="btn btn-primary btn-xs">Cetak</a>
<hr/>
<p>Total mahasiswa yang telah mengisi kinerja dosen sebanyak <strong><?=$totalMhs[0]['total']?></strong> orang</p>
<hr/>
<h4>Standar Penilaian Kinerja Dosen</h4>
<div class="row">
  <div class="col-md-4">
  <table class="table table-striped">
      <thead>
          <tr>
                <th>Rerata Skor</th>
                <th>Klasifikasi Kinerja Dosen</th>
          </tr>
      </thead>
      <tbody>
          <tr>
                <td>>4.00</th>
                <td>Sangat Baik</td>
          </tr>
          <tr>
                <td>>3.00 - <4.00</th>
                <td>Baik</td>
          </tr>
          <tr>
                <td>>2.00 - <3.00</td>
                <td>Cukup</td>
          </tr>
          <tr>
                <td>>1.00 - <2.00</th>
                <td>Kurang</td>
          </tr>
          <tr>
                <td><1.00</th>
                <td>Sangat Kurang</td>
          </tr>
      </tbody>
  </table>
  </div>
</div>
<hr/>
<table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>NIDN</th>
                <th>NAMA</th>
                <th>SCORE</th>
                <th>DETAIL</th>
            <tr>
        <thead>
        <tbody>
        <?php
            $num = 1;
            for ($j=0; $j < count($allscore); $j++) { 
                    echo "<tr>";
                    echo "<td>".$num++."</td>";
                    echo "<td>".$allscore[$j]['rft_nidn']."</td>";
                    echo "<td>".$allscore[$j]['rft_nama_dosen'].", ".$allscore[$j]['jengped']."</td>";
                    if ($allscore[$j]['avg'] !== null) {
                        echo "<td style='font-size:20px;'><strong>".$allscore[$j]['avg']."</strong></td>";
                    } else {
                        echo "<td>0</td>";
                    }
                    echo "<td><a href='".base_url()."Prodi/detail_penilaian/".$this->encrypt->encode($allscore[$j]['rft_nidn'])."/".$this->encrypt->encode($allscore[$j]['rft_kdprodi'])."' class='btn btn-success btn-xs'>detail</a></td>";
                    echo "</tr>";
            }
            $num = 1;
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

<script>
    var semester = document.getElementById('semester');

    for (let index = 0; index < semester.options.length; index++) {
        if (semester.options[index].value == "<?=$semester?>") {
            semester.options[index].setAttribute('selected', 'true');
        };
    };
</script>
