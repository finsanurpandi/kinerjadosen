<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Reset Password | Mahasiswa</title>
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

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style>
      .login-box-body{
          width: 600px;
          margin:-100px;
      }
    </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
<?php
if (@$this->session->flashdata('update') !== true) {
?>
    <p class="login-box-msg"><strong>Masukan password baru anda.</strong></p>

    <form method="post">
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password Baru" name="pass" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Konfirmasi Password" name="cpass" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
<p class="text-muted text-center">Perubahan password ini tidak akan mempengaruhi password untuk mengakses Sistem Informasi Akademik</p>
      <div class="row">
        <div class="col-xs-8">
          
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" name="kirim" class="btn btn-primary btn-block btn-flat">Ganti Password</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
<?php } else {
?>
<p class="text-muted text-center">Password anda telah berhasil kami ubah. Silahkan melakukan login dengan memilih tombol login di bawah ini.</p>
<div class="text-center">
    <a href="<?=base_url()?>login/mahasiswa" class="btn btn-primary btn-lg">LOGIN</a>
</div>
<?php } ?>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->


<!-- jQuery 3 -->
<script src="<?=base_url()?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?=base_url()?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?=base_url()?>assets/plugins/iCheck/icheck.min.js"></script>

</body>
</html>
