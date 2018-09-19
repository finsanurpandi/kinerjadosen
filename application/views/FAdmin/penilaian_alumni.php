

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <h1>
        Data Alumni
        <!-- <small>it all starts here</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url()?>feedbackadmin"><i class="fa fa-dashboard"></i> Hasil Penilaian</a></li>
        <li class="active">Alumni</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Program Studi <?=$prodi[0]['prodi']?></h3>
        </div>
        <div class="box-body">
<!-- conternt here -->
<form class="form-inline">
  <div class="form-group">
    <label for="exampleInputName2">dari</label>
    <input type="text" name="dari" class="form-control" placeholder="2014/2015">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail2">sampai</label>
    <input type="email" name="sampai" class="form-control" placeholder="2017/2018">
  </div>
  <button type="submit" name="filter" class="btn btn-default">filter</button>
</form>

<hr/>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Data Lulusan</h3>
    </div>
    <div class="box-body">
    <div class="row">
    <div class="col-md-6">

    <table class="table table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Tahun Akademik</th>
            <th>Jumlah Lulusan</th>
        <tr>
    </thead>
    <tbody>
<?php
$no = 1;
$jml = 0;
foreach ($jmlalumni as $key => $value) {
?>
        <tr>
            <td><?=$no++?></td>
            <td><?=$value['tahun_akademik']?></td>
            <td><?=$value['jumlah']?></td>
        </tr>
<?php 
$jml += $value['jumlah'];
} 
?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" align="right"><strong>Total</strong></td>
            <td><?=$jml?></td>
        </tr>
    <tfoot>
    </table>
    </div>
    <div class="col-md-6">
        <canvas id="barChart" style="height:230px"></canvas>
        <!-- <canvas id="lineChart" style="height:250px"></canvas> -->
    </div>
    </div>
    </div><!-- /.box-body -->
</div><!-- /.box -->
<!-- DONUT CHART -->
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Persentase Status Alumni</h3>
    </div>
    <div class="box-body">
    <div class="row">
    <div class="col-md-6">
    <table class="table">
            <thead>
                <tr class="active">
                    <th>#</th>
                    <th>Status</th>
                    <th>Persentase</th>
                <tr>
            </thead>
            <tbody>
                <tr class="success">
                    <td>1</td>
                    <td>Bekerja</td>
                    <td><?=$bekerja?>%</td>
                <tr>
                <tr class="info">
                    <td>2</td>
                    <td>Wirausaha</td>
                    <td><?=$wirausaha?>%</td>
                <tr>
                <tr class="warning">
                    <td>3</td>
                    <td>Belum Bekerja</td>
                    <td><?=$belumbekerja?>%</td>
                <tr>
                <tr class="danger">
                    <td>4</td>
                    <td>Tidak Bekerja/Berkeluarga</td>
                    <td><?=$tidakbekerja?>%</td>
                <tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-6">
        <canvas id="pieChart" style="height:250px"></canvas>
    </div>
    </div>
    </div><!-- /.box-body -->
</div><!-- /.box -->

<div class="row">
<div class="col-md-6">
<!-- DONUT CHART -->
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Rata-Rata Waktu Tunggu</h3>
    </div>
    <div class="box-body">
        <p class="text-center" style="font-size:80px;font-wight:bold;">
            <?=$waktutunggu?> Bulan
        </p>
        <p class="text-center" style="margin-top:-30px;margin-bottom:30px;">dari total <?=count($alumni)?> alumni yang menanggapi, dengan <?=$jml_bekerja?> alumni yang bekerja</p>
    </div><!-- /.box-body -->
</div><!-- /.box -->
</div><!-- col-md-6 -->

<div class="col-md-6">
<!-- BAR CHART -->
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Persentase Bekerja Sesuai Bidang</h3>
    </div>
    <div class="box-body">
        <div class="chart">
        <p class="text-center" style="font-size:80px;font-wight:bold;">
            <?=$sesuaibidang?>%
        </p>
        <p class="text-center" style="margin-top:-30px;margin-bottom:30px;">yang bekerja sesuai bidang</p>
        </div>
    </div><!-- /.box-body -->
</div><!-- /.box -->
</div><!-- col-md-6 -->
</div> <!-- ROW -->


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


<script>
let labels = [];
let datas = [];

<?php
foreach ($jmlalumni as $key => $value) {
?>
labels.push("<?=$value['tahun_akademik']?>");
datas.push(<?=$value['jumlah']?>);
<?php } ?>

</script>


