
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

    function getYear($smtr, $str)
    {
        $year = substr($str, 0,4);
        switch ($smtr) {
            case '1':
                $year = (int)$year-((int)$smtr-1);
                return $year;
                break;
            case '2':
                $year = (int)$year-((int)$smtr-2);
                return $year;
                break;
            case '3':
                $year = (int)$year-((int)$smtr-2);
                return $year;
                break;
            case '4':
                $year = (int)$year-((int)$smtr-3);
                return $year;
                break;
            case '5':
                $year = (int)$year-((int)$smtr-3);
                return $year;
                break;
            case '6':
                $year = (int)$year-((int)$smtr-4);
                return $year;
                break;
            case '7':
                $year = (int)$year-((int)$smtr-4);
                return $year;
                break;
            case '8':
                $year = (int)$year-((int)$smtr-5);
                return $year;
                break;
        }
    }

    $ruang = array(
        'IF-1.1', 'IF-1.2', 'IF-1.3', 'IF-1.4',
        'IF-2.1', 'IF-2.2', 'IF-2.3', 'IF-2.4',
        'IF-3.1'
    );

    $kelas = array(0 => 'A', 1 => 'B', 2 => 'C', 3 => 'D', 4 => 'E');

    $ts = substr($setting['semester'], 0,4);
    $tahun = array();

    for ($i=0; $i < 4; $i++) { 
        $tahun[$i] = $ts - $i;
    };

    $thnsemester = array();

    // for ($i=0; $i < count($if); $i++) { 
    //     $thnsemester[$i] = getYear($if[$i]['rft_smtr'],$setting['semester']);
    // }

  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Jadwal Perkuliahan
        <small>Tahun Akademik <?=$setting['rft_tahun_ajaran']?> Semester <?=getSemester($setting['semester'])?></small>
      </h1>
      <ol class="breadcrumb">
        <li class="active"><i class="fa fa-dashboard"></i> Jadwal</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Fakultas Teknik, Universitas Suryakancana</h3>
        </div>
        <div class="box-body">
<!-- conternt here -->

        <button class="btn btn-success btn-xs" type="button" data-target="#tmbhJadwal" data-toggle="modal">
            <i class="fa fa-plus"></i> tambah
        </button>
        <br/><br/>
        
<?php
  if (@$this->session->flashdata('success') == true) {
?>
    <div class="alert alert-success">Data berhasil ditambahkan!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <br/>
    </div>

<?php
  }
?> 

<?php
    if ($this->session->kdprodi == '22201') {
?>


<?php

$thn = substr($setting['kd_semester'],0,4);
    
for ($i=0; $i < count($jadwal); $i++) { 
    $num = 1;
    echo "<div class='alert alert-info'>SI ".$thn."</div>";
    echo "<table class='table table-striped'>";
    echo "<tr>";
    echo "<th>#</th>";
    echo "<th>Kode</th>";
    echo "<th>Matakuliah</th>";
    echo "<th>Dosen</th>";
    echo "<th>Hari</th>";
    echo "<th>Waktu</th>";
    echo "<th>Ruang</th>";
    echo "</tr>";
    for ($j=0; $j < count($jadwal[$i][0]); $j++) { 
        echo "<tr>";
        echo "<td>".$num++."</td>";
        echo "<td>".$jadwal[$i][0][$j]['kode']."</td>";
        echo "<td>".$jadwal[$i][0][$j]['nama']."</td>";
        echo "<td>".$jadwal[$i][0][$j]['dosen']."</td>";
        echo "<td>".$jadwal[$i][0][$j]['hari']."</td>";
        echo "<td>".$jadwal[$i][0][$j]['waktu']."</td>";
        echo "<td>".$jadwal[$i][0][$j]['ruang']."</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<br/>";
    $thn -= 1;
}

} elseif ($this->session->kdprodi == '26201') {

?>

<?php
    $thn = substr($setting['kd_semester'],0,4);
    
    for ($i=0; $i < count($jadwal); $i++) { 
        $num = 1;
        echo "<div class='alert alert-info'>TI ".$thn."</div>";
        echo "<table class='table table-striped'>";
        echo "<tr>";
        echo "<th>#</th>";
        echo "<th>Kode</th>";
        echo "<th>Matakuliah</th>";
        echo "<th>Dosen</th>";
        echo "<th>Hari</th>";
        echo "<th>Waktu</th>";
        echo "<th>Ruang</th>";
        echo "</tr>";
        for ($j=0; $j < count($jadwal[$i][0]); $j++) { 
            echo "<tr>";
            echo "<td>".$num++."</td>";
            echo "<td>".$jadwal[$i][0][$j]['kode']."</td>";
            echo "<td>".$jadwal[$i][0][$j]['nama']."</td>";
            echo "<td>".$jadwal[$i][0][$j]['dosen']."</td>";
            echo "<td>".$jadwal[$i][0][$j]['hari']."</td>";
            echo "<td>".$jadwal[$i][0][$j]['waktu']."</td>";
            echo "<td>".$jadwal[$i][0][$j]['ruang']."</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<br/>";
        $thn -= 1;
    }

} elseif ($this->session->kdprodi == '55201') {
    // echo "<pre>";
    // print_r($jadwal);
    // echo "</pre>";

    // echo count($jadwal[1][0]);
    $thn = substr($setting['kd_semester'],0,4);

    for ($i=0; $i < count($jadwal); $i++) { 
        
        echo "<div class='alert alert-info'>IF ".$thn."</div>";

        for ($j=0; $j < count(@$jadwal[$i]); $j++) { 
            $num = 1;
            if ($j == 0) {
                echo "<strong>Kelas A</strong>";
            } elseif ($j == 1) {
                echo "<strong>Kelas B</strong>";
            } elseif ($j == 2) {
                echo "<strong>Kelas C</strong>";
            } elseif ($j == 3) {
                echo "<strong>Kelas D</strong>";
            } elseif ($j == 4) {
                echo "<strong>Kelas E</strong>";
            }

            echo "<table class='table table-striped'>";
            echo "<tr>";
            echo "<th>#</th>";
            echo "<th>Kode</th>";
            echo "<th>Matakuliah</th>";
            echo "<th>Dosen</th>";
            echo "<th>Hari</th>";
            echo "<th>Waktu</th>";
            echo "<th>Ruang</th>";
            echo "</tr>";
            for ($k=0; $k < count(@$jadwal[$i][$j]); $k++) { 
                echo "<tr>";
                echo "<td>".$num++."</td>";
                echo "<td>".$jadwal[$i][$j][$k]['kode']."</td>";
                echo "<td>".$jadwal[$i][$j][$k]['nama']."</td>";
                echo "<td>".$jadwal[$i][$j][$k]['dosen']."</td>";
                echo "<td>".$jadwal[$i][$j][$k]['hari']."</td>";
                echo "<td>".$jadwal[$i][$j][$k]['waktu']."</td>";
                echo "<td>".$jadwal[$i][$j][$k]['ruang']."</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "<br/>";
        }


        
        $thn -= 1;
    }
?>
<?php

    
}
?>



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
  <div class="modal fade modal-success-custom" tabindex="-1" role="dialog" id="tmbhJadwal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Form Input Jadwal</h4>
      </div>
      <div class="modal-body">
        <form method="post">
            <!-- <div class="form-group">
                <label>Kode Prodi</label>
                <select name="kdprodi" class="form-control" id="kdprodi" onchange="getMatkul();" required>
                    <option></option>
                    <option value="22201">Teknik Sipil</option>
                    <option value="26201">Teknik Industri</option>
                    <option value="55201">Teknik Informatika</option>
                </select>
            </div> -->
            <!-- <div class="form-group">
                <label>Kode - Nama Matakuliah</label>
                <select name="matakuliah" id="matkul" class="form-control select-add-jadwal" style="width:100%;" required>
                    <option></option>
                </select>
            </div> -->
            <div class="form-group">
                <label>Kode - Nama Matakuliah</label>
                <select name="matakuliah" id="matkul" class="form-control select-add-jadwal" style="width:100%;" required>
                    <option></option>
                <?php
                foreach ($matkul as $key => $value) {
                    echo "<option value='".$value['rft_kode_matakuliah'].",".$value['rft_nama_matakuliah'].",".$value['rft_smtr']."'>".$value['rft_kode_matakuliah']."-".$value['rft_nama_matakuliah']."</option>";
                }   
                ?>
                </select>
            </div>
            <div class="form-group">
                <label>Dosen Pengampu</label>
                <select name="dosen" class="form-control select-add-jadwal" style="width:100%;" required>
                <option></option>
                <?php
                foreach ($dosen as $key => $value) {
                ?>
                    <option value="<?=$value['NIDN'].'-'.$value['nama']?>"><?=$value['NIDN'].' - '.$value['nama'].', '.$value['jengped']?></option>
                <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label>Kelas</label>
                <br/>
                    <label class="checkbox-inline">
                        <input type="radio" name="kelas" value="A" required> A
                    </label>
                    <label class="checkbox-inline">
                        <input type="radio" name="kelas" value="B" required> B
                    </label>
                    <label class="checkbox-inline">
                        <input type="radio" name="kelas" value="C" required> C
                    </label>
                    <label class="checkbox-inline">
                        <input type="radio" name="kelas" value="D" required> D
                    </label>
                    <label class="checkbox-inline">
                        <input type="radio" name="kelas" value="E" required> E
                    </label>
            </div>
            <div class="form-group">
                <label>Hari</label>
                <select name="hari" class="form-control select-add-jadwal" style="width:100%" >
                    <option></option>
                    <option value="senin">Senin</option>
                    <option value="selasa">Selasa</option>
                    <option value="rabu">Rabu</option>
                    <option value="kamis">Kamis</option>
                    <option value="jumat">Jumat</option>
                    <option value="sabtu">Sabtu</option>
                </select>
            </div>
            <div class="form-group">
                <label>Waktu</label>
                <input type="text" name="waktu" class="form-control" placeholder="hh.mm-hh.mm" />
            </div>
            <div class="form-group">
                <label>Ruangan</label>
                <select name="ruang" class="form-control select-add-jadwal" style="width:100%">
                <option></option>
                <?php
                    foreach ($ruang as $value) {
                ?>
                    <option value="<?=$value?>"><?=$value?></option>
                <?php } ?>
                </select>
            </div>
      </div>
      <div class="modal-footer">
        <input type="reset" class="btn btn-default btn-xs" data-dismiss="modal" value="Close">
        <input type="submit" class="btn btn-success btn-xs" name="addJadwal" value="Submit"/>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
