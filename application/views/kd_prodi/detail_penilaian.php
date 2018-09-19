
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

    $dataSemester = array();
    $dataAvg = array();

    foreach ($avg as $key => $value) {
        $dataSemester[] += $value['semester'];
        $dataAvg[] += $value['avg'];
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
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">Blank page</li>
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
        <a href="<?=base_url()?>prodi" class="btn btn-default btn-xs"><i class="fa fa-arrow-left"></i> kembali</a>
        <hr/>
        <!-- LINE CHART -->
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><a href="#" class="" data-widget="collapse">Grafik Penilaian Per Semester</a></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="lineChart" style="height:250px"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

<!-- conternt here -->
<form method="post" class="form-inline">
    <div class="form-group">
        <label for="exampleInputName2">Semester</label>
        <select name="semester" id="semester" class="form-control" onchange="this.form.submit();">
            <?php
                foreach ($allSemester as $key => $value) {
                    echo "<option value=".$value['semester'].">".$value['semester']."</option>";        
                }
            ?>
        </select>
  </div>
</form>
<hr/>

<!-- LINE CHART -->
<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><a href="#" class="" data-widget="collapse">Grafik Penilaian Per Matakuliah</a></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="lineChart2" style="height:250px"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

<table class="table table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Kode Matakuliah</th>
            <th>Nama Matakuliah</th>
            <th>Kelas</th>
            <th>Score</th>
            <th>Detail</th>
        </tr>
    <tbody>
    <?php
    $num = 1;
    foreach ($matkul as $key => $value) {
        echo "<tr>";
        echo "<td>".$num++."</td>";
        echo "<td>".$value['rft_kode_matakuliah']."</td>";
        echo "<td>".$value['rft_nama_matakuliah']."</td>";
        echo "<td>".$value['kelas']."</td>";

        if ($value['avg'] !== null) {
            echo "<td style='font-size:20px;'><strong>".$value['avg']."</strong></td>";
            echo "<td><a href='".base_url()."Cetak/cetak_penilaian/".$this->encrypt->encode($dosen[0]['NIDN'])."/".$this->encrypt->encode($value['rft_kode_matakuliah'])."/".$this->encrypt->encode($value['kelas'])."/".$this->encrypt->encode($semester)."' class='btn btn-primary btn-xs' target='_blank'>cetak</a> &nbsp;";
            echo "<a href='".base_url()."Prodi/detail_uraian/".$this->encrypt->encode($dosen[0]['NIDN'])."/".$this->encrypt->encode($value['rft_kode_matakuliah'])."/".$this->encrypt->encode($value['kelas'])."/".$this->encrypt->encode($semester)."' class='btn btn-success btn-xs'>detail</a></td>";
        } else {
            echo "<td>0</td>";
            echo "<td><button type='button' class='btn btn-default btn-xs' disabled='true'>cetak</button>&nbsp;";
            echo "<button type='button' class='btn btn-default btn-xs' disabled='true'>detail</button></td>";
        }
        
        echo "</tr>";
    }
    ?>
    </tbody>
    </thead>
</table>
<hr/>
<a href="<?=base_url()?>prodi" class="btn btn-default btn-xs"><i class="fa fa-arrow-left"></i> kembali</a>
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
<!-- ChartJS -->
<script src="<?=base_url()?>assets/bower_components/chart.js/Chart.js"></script>
<script>
    var semester = document.getElementById('semester');

    for (let index = 0; index < semester.options.length; index++) {
        if (semester.options[index].value == "<?=$semester?>") {
            semester.options[index].setAttribute('selected', 'true');
        };
    };

    

$(function () {
var dataLabel = ['0'];
var dataGrafik = [0];
var dataLabel2 = ['0'];
var dataGrafik2 = [0];

<?php foreach ($dataSemester as $key => $value) { ?>
      dataLabel.push(<?=$value?>);  
<?php } ?>

<?php foreach ($dataAvg as $key => $value) { ?>
      dataGrafik.push(<?=$value?>);  
<?php } ?>

<?php foreach ($matkul as $key => $value) { 
?>
      dataLabel2.push("<?=$value['rft_nama_matakuliah'].' - '.$value['kelas']?>");
<?php
  if ($value['avg'] !== null) {
?>
      dataGrafik2.push(<?=$value['avg']?>);    
<?php
} else {
?>
      dataGrafik2.push(0);    
<?php
}}
?>


var lineChartData = {
  labels  : dataLabel,
  datasets: [
    {
      label               : 'Kinerja Dosen',
      fillColor           : 'rgba(60,141,188,0.9)',
      strokeColor         : 'rgba(60,141,188,0.8)',
      pointColor          : '#3b8bba',
      pointStrokeColor    : 'rgba(60,141,188,1)',
      pointHighlightFill  : '#fff',
      pointHighlightStroke: 'rgba(60,141,188,1)',
      data                : dataGrafik
    }
  ]
}

var lineChartData2 = {
  labels  : dataLabel2,
  datasets: [
    {
      label               : 'Kinerja Dosen Matakuliah',
      fillColor           : 'rgba(60,141,188,0.9)',
      strokeColor         : 'rgba(60,141,188,0.8)',
      pointColor          : '#3b8bba',
      pointStrokeColor    : 'rgba(60,141,188,1)',
      pointHighlightFill  : '#fff',
      pointHighlightStroke: 'rgba(60,141,188,1)',
      data                : dataGrafik2
    }
  ]
}

var lineChartOptions = {
  //Boolean - If we should show the scale at all
  showScale               : true,
  //Boolean - Whether grid lines are shown across the chart
  scaleShowGridLines      : false,
  //String - Colour of the grid lines
  scaleGridLineColor      : 'rgba(0,0,0,.05)',
  //Number - Width of the grid lines
  scaleGridLineWidth      : 1,
  //Boolean - Whether to show horizontal lines (except X axis)
  scaleShowHorizontalLines: true,
  //Boolean - Whether to show vertical lines (except Y axis)
  scaleShowVerticalLines  : true,
  //Boolean - Whether the line is curved between points
  bezierCurve             : true,
  //Number - Tension of the bezier curve between points
  bezierCurveTension      : 0.3,
  //Boolean - Whether to show a dot for each point
  pointDot                : true,
  //Number - Radius of each point dot in pixels
  pointDotRadius          : 4,
  //Number - Pixel width of point dot stroke
  pointDotStrokeWidth     : 1,
  //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
  pointHitDetectionRadius : 20,
  //Boolean - Whether to show a stroke for datasets
  datasetStroke           : true,
  //Number - Pixel width of dataset stroke
  datasetStrokeWidth      : 2,
  //Boolean - Whether to fill the dataset with a color
  datasetFill             : true,
  //String - A legend template
  legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
  //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
  maintainAspectRatio     : true,
  //Boolean - whether to make the chart responsive to window resizing
  responsive              : true
}



//-------------
//- LINE CHART -
//--------------
var lineChartCanvas          = $('#lineChart').get(0).getContext('2d');
var lineChart                = new Chart(lineChartCanvas);
var lineChartOptions         = lineChartOptions;
lineChartOptions.datasetFill = false;
lineChart.Line(lineChartData, lineChartOptions);

//-------------
//- LINE CHART -
//--------------
var lineChartCanvas2          = $('#lineChart2').get(0).getContext('2d');
var lineChart2                = new Chart(lineChartCanvas2);
var lineChartOptions2         = lineChartOptions;
lineChartOptions2.datasetFill = false;
lineChart2.Line(lineChartData2, lineChartOptions2);
})
</script>
