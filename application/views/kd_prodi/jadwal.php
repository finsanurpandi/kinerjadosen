
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

    for ($i=0; $i < count($if); $i++) { 
        $thnsemester[$i] = getYear($if[$i]['rft_smtr'],$setting['semester']);
    }

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
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">Blank page</li>
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

<div class='alert alert-info'>Teknik Sipil</div>
<?php

    for ($i=0; $i < count($tahun); $i++) { 
        for ($j=0; $j < 1; $j++) { 
            $head = 0;
            echo "<ul class='list-group'>";
            
            for ($k=0; $k < count($si); $k++) { 
                
                if ($tahun[$i] == $thnsemester[$k] && $si[$k]['rft_kelas'] == 'A') {
                    if ($head == 0) {
                        echo "<li class='list-group-item active'>";
                        echo "IF-A-".$tahun[$i]. '<br/>';
                        echo "</li>";
                        $head += 1;
                    }
                        echo "<li class='list-group-item'>";
                        echo $si[$k]['rft_kode_matakuliah']." - ".$si[$k]['rft_nama_matakuliah']." - <strong>".$si[$k]['rft_nama_dosen'].", ".$si[$k]['jengped']."</strong> || ".ucwords($si[$k]['rft_hari']).", ".$si[$k]['rft_waktu'].", Ruang ".$si[$k]['rft_ruang'];
                        echo "<span class='pull-right'><button class='btn btn-success btn-xs' type='button'><i class='fa fa-pencil'></i></button>&nbsp;";
                        echo "<button class='btn btn-danger btn-xs' type='button'><i class='fa fa-trash-o'></i></button></span>";
                        echo "</li>";
                }
                echo "</ul>";
            }
            $head = 0;
        }
    }

} elseif ($this->session->kdprodi == '26201') {

?>
<div class='alert alert-info'>Teknik Industri</div>
<?php

    for ($i=0; $i < count($tahun); $i++) { 
        for ($j=0; $j < 1; $j++) { 
            $head = 0;
            echo "<ul class='list-group'>";
            
            for ($k=0; $k < count($ti); $k++) { 
                
                if ($tahun[$i] == $thnsemester[$k] && $ti[$k]['rft_kelas'] == 'A') {
                    if ($head == 0) {
                        echo "<li class='list-group-item active'>";
                        echo "IF-A-".$tahun[$i]. '<br/>';
                        echo "</li>";
                        $head += 1;
                    }
                        echo "<li class='list-group-item'>";
                        echo $ti[$k]['rft_kode_matakuliah']." - ".$ti[$k]['rft_nama_matakuliah']." - <strong>".$ti[$k]['rft_nama_dosen'].", ".$ti[$k]['jengped']."</strong> || ".ucwords($ti[$k]['rft_hari']).", ".$ti[$k]['rft_waktu'].", Ruang ".$ti[$k]['rft_ruang'];
                        echo "<span class='pull-right'><button class='btn btn-success btn-xs' type='button'><i class='fa fa-pencil'></i></button>&nbsp;";
                        echo "<button class='btn btn-danger btn-xs' type='button'><i class='fa fa-trash-o'></i></button></span>";
                        echo "</li>";
                }
                echo "</ul>";
            }
            $head = 0;
        }
    }

} elseif ($this->session->kdprodi == '55201') {

?>
<div class='alert alert-info'>Teknik Informatika</div>
<?php

    for ($i=0; $i < count($tahun); $i++) { 
        for ($j=0; $j < count($kelas); $j++) { 
            $head = 0;
            echo "<ul class='list-group'>";
            
            for ($k=0; $k < count($if); $k++) { 
                
                if ($tahun[$i] == $thnsemester[$k] && $kelas[$j] == $if[$k]['rft_kelas']) {
                    if ($head == 0) {
                        echo "<li class='list-group-item active'>";
                        echo "IF-".$kelas[$j].' '.$tahun[$i]. '<br/>';
                        echo "</li>";
                        $head += 1;
                    }
                        echo "<li class='list-group-item'>";
                        echo $if[$k]['rft_kode_matakuliah']." - ".$if[$k]['rft_nama_matakuliah']." - <strong>".$if[$k]['rft_nama_dosen'].", ".$if[$k]['jengped']."</strong> || ".ucwords($if[$k]['rft_hari']).", ".$if[$k]['rft_waktu'].", Ruang ".$if[$k]['rft_ruang'];
                        echo "<span class='pull-right'><button class='btn btn-success btn-xs' type='button'><i class='fa fa-pencil'></i></button>&nbsp;";
                        echo "<button class='btn btn-danger btn-xs' type='button'><i class='fa fa-trash-o'></i></button></span>";
                        echo "</li>";
                }
                echo "</ul>";
            }
            $head = 0;
        }
    }
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
                        <input type="radio" name="kelas" value="A"> A
                    </label>
                    <label class="checkbox-inline">
                        <input type="radio" name="kelas" value="B"> B
                    </label>
                    <label class="checkbox-inline">
                        <input type="radio" name="kelas" value="C"> C
                    </label>
                    <label class="checkbox-inline">
                        <input type="radio" name="kelas" value="D"> D
                    </label>
                    <label class="checkbox-inline">
                        <input type="radio" name="kelas" value="E"> E
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
