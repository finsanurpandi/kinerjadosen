<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Laporan Penilaian Kinerja Dosen</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>
        #cetakpenilaian {
            width: 960px;
            margin-left: 50px;
            margin-top: 20px;
            padding: 30px;
            display: block;
            border: 1px solid;
        }
        input{
            margin-left: 50px;
            margin-top: 10px;
        }
        .title > p {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: -10px;
        }
        table {
            margin-top: 20px;
        }

        .table.khusus > thead > tr > th,
        .table.khusus > tbody > tr > th,
        .table.khusus > tfoot > tr > th,
        .table.khusus > thead > tr > td,
        .table.khusus> tbody > tr > td,
        .table.khusus > tfoot > tr > td {
            padding: 0px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 0px solid #fff;
        }

        .table > thead > tr > th,
        .table > tbody > tr > th,
        .table > tfoot > tr > th,
        .table > thead > tr > td,
        .table > tbody > tr > td,
        .table > tfoot > tr > td {
            padding: 3px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #ddd;
        }

        .wrap{
            display: inline-block;
            width:100%;
        }

        .box1{
            display: block;
            width: 100%;
            height: 200px;
            padding-top: 80px;
            border: 1px solid #000;
            float: left;
            margin-bottom: 30px;
        }
        .box2{
            display: block;
            width: 100px;
            height: 100px;
            padding-top: 80px;
            border: 1px solid #000;
            float: left;
            margin-left: 98px;
            margin-top: -111px;
        }
        .box3{
            display: block;
            width: 100px;
            height: 100px;
            padding-top: 80px;
            border: 1px solid #000;
            float: left;
            margin-left: 98px;
            margin-top: -111px;
        }

        .container {
            display: grid;
            grid-template-columns: 0.3fr 3fr;
            grid-auto-rows: minmax(100px, auto);
        }

        .container > div {
            background: #fff;
            padding: 1em;
        }

        .item-a {
            grid-column-start: 1;
            grid-column-end: 2;
            grid-row-start: 1;
            grid-row-end: 2;
        }

        .item-b {
        grid-column-start: 2;
        grid-column-end: 3;
        grid-row-start: 1;
        grid-row-end: 2;
        }

        tbody > tr > td {
            font-size: 10px;
        }



    </style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
<?php
$periode = null;

if (substr($setting['kd_semester'], -1) == '1') {
    $periode = 'GANJIL';
} else {
    $periode = 'GENAP';
}
?>
<input type="button" class="btn btn-primary btn-xs" onclick="printDiv('cetakpenilaian')" value="Cetak" />
    <div id="cetakpenilaian">
       <h3><img src="<?=base_url()?>assets/img/ft_logo.png" width="8%"/> Fakultas Teknik - Universitas Suryakancana</h3>
       <p style="margin-top:-30px;margin-left:67px;">Jalan Pasir Gede Raya, Bojongherang, Kecamatan Cianjur 43216</p>
       <hr/>
       <div class="text-center">
            <p style="font-size:18px;"><strong>PENILAIAN KINERJA DOSEN <br/>SEMESTER <?=$periode?> TAHUN AKADEMIK <?=$setting['kd_tahun_akademik']?></strong></p>
            <hr/>
       </div>
<table>
<tr>
    <td width="400">
        <strong>NIDN - Nama</strong>
        <p class="text-muted">
        <?=$dosen[0]['NIDN'].' - '.$dosen[0]['nama']?>
        </p>
    </td>
    <td>
        <strong>Kelas</strong>
        <p class="text-muted">
        <?=$mkul[0]['rft_kelas']?>
        </p>
    </td>
</tr>

<tr>
    <td>
        <strong>Kode - Nama Matakuliah</strong>
        <p class="text-muted">
        <?=$mkul[0]['rft_kode_matakuliah'].' - '.$mkul[0]['rft_nama_matakuliah']?>
        </p>
    </td>
    <td>
        <strong>Jumlah Mahasiswa Mengisi</strong>
        <p class="text-muted">
        <?=$done.' dari '.$total.' mahasiswa.'?>
        </p>
    </td>
</tr>
</table>

<hr/>

<table class="table table-border table-hover">
<thead>
    <tr>
        <th>#</th>
        <th>Uraian Kinerja</th>
        <th>Skor Rata-rata</th>
    </tr>
</thead>
<tbody>
<?php
$total = 0;
$totalnilai = 0;
$totaluraian = 0;
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
            $totalnilai += $uraian[$j]['avg'];
            $totaluraian += 1;
            $pembagi += 1;
            }
    }
?>
    <tr class="success">
        <th colspan="2"><span class="pull-right">Nilai Rata-Rata <?=$aspek[$i]['aspek_penilaian']?> = </span></th>
        <th style="font-size:16px;">
        <?php
        echo round($total/$pembagi, 4);
        ?>
        </th>
    </tr>
<?php
$total = 0;
$pembagi = 0;
}
?>
    
</tbody>
</table>

<p>Total nilai rata-rata adalah <span style="font-size:18px;font-weight:bold;"><?=round($totalnilai/$totaluraian, 4)?></span></p>
<hr/>
<p>Penilaian: </p>
<div class="box1">

</div>

<div class="text-right">
<p>Cianjur, <?=date("d-M-Y")?></p>
<p style="margin-top:-10px;">Ketua Prodi <?=ucwords($prodi[0]['ProgramStudi'])?></p>
<br/><br/><br/>
<p><?=$prodi[0]['KetuaProdi']?></p>
</div>

       
    </div>


    

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script type="text/javascript">
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
        
    </script>
  </body>
</html>