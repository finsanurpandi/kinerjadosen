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
        Master Data Perusahaan
        <!-- <small>it all starts here</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> Master Data</a></li>
        <li><a href="<?=base_url()?>feedbackadmin/perusahaan">Perusahaan</a></li>
        <li class="active">Detail</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Detail Data Perusahaan</h3>
        </div>
        <div class="box-body">
<!-- conternt here -->
<a href="<?=base_url()?>feedbackadmin/perusahaan" class="btn btn-default btn-xs"><i class="fa fa-arrow-left"></i> Kembali</a>
<hr/>
<?php

if (count($perusahaan) == 0) {
    echo "Tidak ada data";
} else {

?>

<strong>Nama Perusahaan</strong>
<p><?=$perusahaan[0]['nama_perusahaan']?></p>

<strong>Alamat</strong>
<p><?=$perusahaan[0]['alamat']?></p>

<strong>Bidang Usaha</strong>
<p><?=$perusahaan[0]['bidang_usaha']?></p>

<strong>Email</strong>
<p><?=$perusahaan[0]['email']?></p>

<strong>Jumlah Alumni yang Bekerja</strong>
<p><?=count($perusahaan)?></p>

<hr/>
<strong>Data Alumni</strong>
<hr/>



<table class="table table-striped">
<thead>
    <tr>
        <th>#</th>
        <th>NPM</th>
        <th>Nama Alumni</th>
        <th>Alamat</th>
        <th>Email</th>
        <th>No Tlp</th>
        <th>Posisi</th>
        <th>Mulai Bekerja</th>
    </tr>
</thead>
<tbody>
    <?php
    $no = 1;
        foreach ($perusahaan as $key => $value) {
    ?>
    <tr>
        <td><?=$no++?></td>
        <td><?=$value['npm']?></td>
        <td><?=$value['nama']?></td>
        <td><?=$value['alamat']?></td>
        <td><?=$value['email']?></td>
        <td><?=$value['no_tlp']?></td>
        <td><?=$value['posisi']?></td>
        <td><?=getMonth($value['bulan_bekerja'])." - ".$value['tahun_bekerja']?></td>
    </tr>
        <?php } ?>
</tbody>
</table>

<?php } ?>

<hr/>
<a href="<?=base_url()?>feedbackadmin/perusahaan" class="btn btn-default btn-xs"><i class="fa fa-arrow-left"></i> Kembali</a>

<!-- end content           -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

