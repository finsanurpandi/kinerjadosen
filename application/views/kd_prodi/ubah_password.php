
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Penilaian Kinerja Dosen
      </h1>
      <ol class="breadcrumb">
        <li class="active"><i class="fa fa-dashboard"></i> Perubahan Password</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Form Perubahan Password</h3>
        </div>
        <div class="box-body">
<!-- conternt here -->

          <p>Selamat datang Prodi <?=ucfirst($this->session->user)?>,</p>
          <p>Untuk dapat mengganti password, silahkan mengisi form di bawah ini.</p>
          <hr/>
<?php
  if (@$this->session->flashdata('success') == true) {
?>
    <div class="alert alert-success">Password berhasil diubah!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <br/>
    </div>

<?php
  }
?> 

<?php
  if (@$this->session->flashdata('wrongpass') == true) {
?>
    <div class="alert alert-warning">Password lama yang anda masukan salah!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <br/>
    </div>

<?php
  }
?> 

<?php
  if (@$this->session->flashdata('wrongconfirm') == true) {
?>
    <div class="alert alert-warning">Password baru dan ulangi password tidak sama!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <br/>
    </div>

<?php
  }
?> 
        <div class="row">
        <div class="col-md-4">
          <form method="post">
            <div class="form-group">
                <label>Password Lama</label>
                <input type="password" class="form-control" name="pass" required/>
            </div>
            <div class="form-group">
                <label>Password Baru</label>
                <input type="password" class="form-control" name="npass" required/>
            </div>
            <div class="form-group">
                <label>Ulangi Password Baru</label>
                <input type="password" class="form-control" name="cpass" required/>
            </div>
            <button type="submit" name="ubahpass" class="btn btn-primary btn-sm">Ubah Password</button>
          </form>
        </div>
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
