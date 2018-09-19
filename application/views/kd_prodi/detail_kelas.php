
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
        KRS Mahasiswa
        <!-- <small>it all starts here</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url()?>kd_prodi"><i class="fa fa-dashboard"></i> Kategori Penilaian</a></li>
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
<?=$mhs[0]['npm'].' - '.$mhs[0]['nama']?>
</p>

<strong>Angkatan</strong>
<p class="text-muted">
<?=$mhs[0]['angkatan']?>
</p>

<strong>Kelas</strong>
<p class="text-muted">
<?=$mhs[0]['kelas']?>
</p>

<strong>Program Studi</strong>
<p class="text-muted">
<?=$mhs[0]['angkatan']?>
</p>

<hr/>

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
foreach ($krs as $key => $value) {

?>
<tr>
      <td><?=$no++?></td>
      <td><?=$value['rft_kode_matakuliah']?></td>
      <td><?=$value['rft_nama_matakuliah']?></td>
      <td><?=$value['rft_sks']?></td>
      <td>
        <form method="post">
            <div class="">
                <select class="" id="kelas" name="kelas" onchange="this.form.submit();">
                <?php
                    if ($value['rft_kelas'] == 'A') {
                        echo "<option></option>";
                        echo "<option value='A' selected='true'>A</option>";
                        echo "<option value='B'>B</option>";
                        echo "<option value='C'>C</option>";
                        echo "<option value='D'>D</option>";
                        echo "<option value='E'>E</option>";
                    } elseif ($value['rft_kelas'] == 'B') {
                        echo "<option></option>";
                        echo "<option value='A'>A</option>";
                        echo "<option value='B' selected='true'>B</option>";
                        echo "<option value='C'>C</option>";
                        echo "<option value='D'>D</option>";
                        echo "<option value='E'>E</option>";
                    } elseif ($value['rft_kelas'] == 'C') {
                        echo "<option></option>";
                        echo "<option value='A'>A</option>";
                        echo "<option value='B'>B</option>";
                        echo "<option value='C' selected='true'>C</option>";
                        echo "<option value='D'>D</option>";
                        echo "<option value='E'>E</option>";
                    } elseif ($value['rft_kelas'] == 'D') {
                        echo "<option></option>";
                        echo "<option value='A'>A</option>";
                        echo "<option value='B'>B</option>";
                        echo "<option value='C'>C</option>";
                        echo "<option value='D' selected='true'>D</option>";
                        echo "<option value='E'>E</option>";
                    } elseif ($value['rft_kelas'] == 'E') {
                        echo "<option></option>";
                        echo "<option value='A'>A</option>";
                        echo "<option value='B'>B</option>";
                        echo "<option value='C'>C</option>";
                        echo "<option value='D'>D</option>";
                        echo "<option value='E' selected='true'>E</option>";
                    } else {
                        echo "<option></option>";
                        echo "<option value='A'>A</option>";
                        echo "<option value='B'>B</option>";
                        echo "<option value='C'>C</option>";
                        echo "<option value='D'>D</option>";
                        echo "<option value='E'>E</option>";
                    }
                ?>
                </select>
                <input type="hidden" name="kdmatkul" value="<?=$value['rft_kode_matakuliah']?>"/>
            </div>
        </form>
      </td>
</tr>
<?php 
            
}
?>
    
</tbody>
</table>
<hr/>
<a href="<?=base_url()?>prodi/kelas" class="btn btn-default btn-xs"><i class="fa fa-arrow-left"></i> kembali</a>

<!-- end content           -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

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

    function getKelas(idkelas)
    {
    var kelas = document.getElementById('kelas');

    for (let index = 0; index < kelas.options.length; index++) {
        if (kelas.options[index].value == idkelas) {
            kelas.options[index].setAttribute('selected', 'true');
        };
    };
    }

    // var semester = document.getElementById('semester');

    // for (let index = 0; index < semester.options.length; index++) {
    //     if (semester.options[index].value == "<?=$semester?>") {
    //         semester.options[index].setAttribute('selected', 'true');
    //     };
    // };

    // $('form').on('submit', function (e) {

    // e.preventDefault();

    // $.ajax({
    // type: 'post',
    // url: 'post.php',
    // data: $('form').serialize(),
    // success: function () {
    //     alert('form was submitted');
    // }
    // });

    // });
    
});
</script>
