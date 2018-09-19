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

function getProdi($prodi)
{
    switch ($prodi) {
        case '55201':
            echo "Teknik Informatika";
            break;
        case '22201':
            echo "Teknik Sipil";
            break;
        case '26201':
            echo "Teknik Industri";
            break;
    }
}

?>

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
        <li><a href="<?=base_url()?>feedbackadmin/alumni">Alumni</a></li>
        <li class="active">Detail</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Detail Data Alumni</h3>
        </div>
        <div class="box-body">
<!-- conternt here -->
<a href="<?=base_url()?>feedbackadmin/alumni" class="btn btn-default btn-xs"><i class="fa fa-arrow-left"></i> Kembali</a>
<hr/>

<div class="row">
<div class="col-md-6">
    <strong>Program Studi</strong>
    <p><?=getProdi($detail[0]['kd_prodi'])?></p>

    <strong>NPM</strong>
    <p><?=$detail[0]['npm']?></p>

    <strong>Nama Alumni</strong>
    <p><?=$detail[0]['nama']?></p>

    <strong>Alamat</strong>
    <p><?=$detail[0]['alamat']?></p>

    <strong>No Telepon</strong>
    <p><?=$detail[0]['no_tlp']?></p>

    <strong>Email</strong>
    <p><?=$detail[0]['email']?></p>

    <strong>Lulus</strong>
    <p><?=getMonth($detail[0]['bln_lulus']).' - '.$detail[0]['thn_lulus']?></p>

    <strong>Status Saat Ini</strong>
    <p><?=$status?></p>
</div> <!-- col-md-6 -->

<?php
    if ($status == 'Sudah Bekerja') {
?>
<div class="col-md-6">
    <strong>Nama Perusahaan</strong>
    <p><?=$detail[0]['nama_perusahaan']?></p>

    <strong>Alamat Perusahaan</strong>
    <p><?=$detail[0]['alamat_pt']?></p>

    <strong>Bidang Usaha</strong>
    <p><?=$detail[0]['bidang_usaha']?></p>

    <strong>Email Perusahaan</strong>
    <p><?=$detail[0]['email_pt']?></p>

    <strong>Posisi</strong>
    <p><?=$detail[0]['posisi']?></p>

    <strong>Mulai Bekerja</strong>
    <p><?=getMonth($detail[0]['bulan_bekerja']).' - '.$detail[0]['tahun_bekerja']?></p>
</div> <!-- col-md-6 -->
    
    <?php } elseif ($status == 'Wirausaha') {
?>

<div class="col-md-6">
    <strong>Nama Tempat Usaha</strong>
    <p><?=$detail[0]['nama_tempat_usaha']?></p>

    <strong>Bidang Usaha</strong>
    <p><?=$detail[0]['bidang_usaha']?></p>

    <strong>Mulai Bekerja</strong>
    <p><?=getMonth($detail[0]['bulan_bekerja']).' - '.$detail[0]['tahun_bekerja']?></p>
</div> <!-- col-md-6 -->

<?php    }?>

</div> <!-- ROW -->



<hr/>
<a href="<?=base_url()?>feedbackadmin/alumni" class="btn btn-default btn-xs"><i class="fa fa-arrow-left"></i> Kembali</a>

<!-- end content           -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

