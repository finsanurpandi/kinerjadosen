<?php
  $bg = array('bg_img_03.jpeg', 'bg_img_01.jpg', 'bg_img_02.jpg', 'bg_img_04.jpg');
  $rand = array_rand($bg);

  $fix = base_url()."assets/img/".$bg[$rand];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Evaluasi Dosen | Mahasiswa</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?=base_url()?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- ICON -->
  <link rel="icon" href="<?=base_url()?>assets/img/ico_ft.png" type="image/x-icon" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url()?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?=base_url()?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url()?>assets//css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?=base_url()?>assets/plugins/iCheck/square/blue.css">
  <!-- Viga font -->
  <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style>
    .login-page{
      background-image: url("<?=$fix?>");
      background-size: cover;
      height: 100%;
      overflow: hidden;
      background-repeat: no-repeat;
      background-position: center center;
    }
    .login-logo{
      background: #fff;
    }

    .login-box{
      margin: 15% auto;
    }

    @media only screen and (min-width: 600px){
      .modal {
        text-align: center;
        padding: 0!important;
      }

      .modal:before {
        content: '';
        display: inline-block;
        height: 100%;
        vertical-align: middle;
        margin-right: -4px;
      }

      .modal-dialog {
        display: inline-block;
        text-align: left;
        vertical-align: middle;
      }
    }
    

    .year {
      font-family: 'Poppins', sans-serif;
      font-size: '20vw';
      font-weight: bold;
      text-transform: uppercase;
      background: linear-gradient(to right, #30CFD0 0%, #330867 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <!-- <a href="../../index2.html"><b>Penilaian Kinerja</b>Dosen</a> -->
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <div class="text-center">
    <a href="http://www.unsur.ac.id" target="_blank" title="Universitas Suryakancana"><img src="<?=base_url()?>assets/img/logo_unsur.png" width="50px"/></a>
    <a href="http://ft.unsur.ac.id" target="_blank" title="Fakultas Teknik"><img src="<?=base_url()?>assets/img/logo_ft.png" width="50px"/></a>
    <hr/>
    </div>
    <p class="login-box-msg">
    Silahkan login untuk mulai melakukan penilaian kinerja dosen.
    </p>

    <form method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="NPM" name="npm" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="pass" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <?php
        if (@$this->session->flashdata('error') == true) {
      ?>
      <small class="text-danger">
        Wrong Username or Password!!!
      </small>

      <?php
        }
      ?>
<br/>
      <div class="row">
        <div class="col-xs-8">
          <!-- <button type="button" class="btn btn-link" data-toggle="modal" data-target="#modalLogin">Tidak bisa login?</button> -->
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" name="login" class="btn btn-primary btn-block btn-flat">Login</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <hr/>
    <div class="text-center">
    Copyright &copy; 2017 Fakultas Teknik <br/>Universitas Suryakancana
    </div>
  </div>
  <!-- /.login-box-body -->
  
</div>
<!-- /.login-box -->

<!-- Modal -->
<div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Form Reset Password</h4>
      </div>
      <div class="modal-body">
        <p>Kami akan mengirimkan link untuk reset password ke email anda. Password baru hanya berlaku untuk Sistem Evaluasi Dosen, tidak berlaku untuk login perwalian.</p>
        <p>Terima kasih.</p>
        <hr/>
        <form method="post">
          <div class="form-group">
            <label for="exampleInputEmail1">NPM</label>
            <input type="number" name="npm" class="form-control" placeholder="Masukan NPM anda." required>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Alamat Email</label>
            <input type="email" name="email" class="form-control" placeholder="Masukan email anda." required>
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-xs" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary btn-xs" name="kirimEmail">Kirim</button>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="text-center">
          <p style="font-size:22px">Selamat Tahun Baru</p>
          <h1 class="year" style="font-size:200px">2019</h1>
          <hr/>
          <p style="font-size:15px">Apa resolusimu tahun ini? sudah siap menggapainya?</p>
          <p style="font-size:15px">Sebelum itu, silakan untuk mengisi penilaian kinerja dosen untuk semester gasal tahun akademik 2018/2019</p>
          <p style="font-size:20px">Semoga tahun ini menjadi lebih baik dari sebelumnya.</p>
        </div>
      </div>
      <div class="modal-footer">
        <div class="text-center">
          <button type="button" class="btn btn-primary btn-xs" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- jQuery 3 -->
<script src="<?=base_url()?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?=base_url()?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?=base_url()?>assets/plugins/iCheck/icheck.min.js"></script>

<script>
$(document).ready(function(){
  $tahun = "<?=$setting['kd_semester']?>";
  if ($tahun == '20181') {
    $('#myModal').modal({
      show: true
    })
  }
});
</script>


</body>
</html>


