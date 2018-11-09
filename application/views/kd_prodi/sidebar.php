<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?=base_url()?>assets/img/user2-160x160.jpg" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>Prodi <?=ucfirst($this->session->user)?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- search form -->
    <!-- <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
      </div>
    </form> -->
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>
      <li id="prodiKinerja">
        <a href="<?=base_url()?>prodi">
          <i class="fa fa-th"></i> <span>Penilaian Kinerja Dosen</span>
        </a>
      </li>
      <li id="prodiJadwal" class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>Jadwal</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li id="prodiDataJadwal"><a href="<?=base_url()?>prodi/jadwal"><i class="fa fa-circle-o"></i> Data Jadwal</a></li>
            <li id="prodiKelas"><a href="<?=base_url()?>prodi/kelas"><i class="fa fa-circle-o"></i> Kelas Mahasiswa</a></li>
          </ul>
        </li>
        <li id="prodiUraian" class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>Uraian</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li id="prodiKategori"><a href="<?=base_url()?>prodi/kategori"><i class="fa fa-circle-o"></i> Kategori</a></li>
            <li id="prodiUraianKinerja"><a href="<?=base_url()?>prodi/uraian"><i class="fa fa-circle-o"></i> Uraian Kinerja Dosen</a></li>
          </ul>
        </li>
        <!-- <li id="prodiInput">
        <a href="<?=base_url()?>loss">
          <i class="fa fa-th"></i> <span>Input Penilaian</span>
        </a>
      </li> -->
        <li>
        <a href="#" data-toggle="modal" data-target="#logoutModal">
          <i class="fa fa-th"></i> <span>Logout</span>
        </a>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>

<!-- Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Logout</h4>
      </div>
      <div class="modal-body">
        Apakah anda yakin akan logout dari halaman ini?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success btn-xs" data-dismiss="modal">Nope</button>
        <a href="<?=base_url()?>login/logout/prodi" class="btn btn-danger btn-xs">Yes, just log me out...</a>
      </div>
    </div>
  </div>
</div>

<script src="<?=base_url()?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<script type="text/javascript">
  var uri = '<?=$this->uri->segment(2)?>';

  function ProdiClearMenu(){
    $('#prodiKinerja').remove('.active');
    $('#prodiJadwal').remove('.active');
    $('#prodiDataJadwal').remove('.active');
    $('#prodiKelas').remove('.active');
    $('#prodiUraian').remove('.active');
    $('#prodiKategori').remove('.active');
    $('#prodiUraianKinerja').remove('.active');
    $('#prodiInput').remove('.active');
  }

	if (uri == '') {
            ProdiClearMenu();
            $('#prodiKinerja').addClass('active');
		} else if (uri == 'jadwal') { 
            $('#prodiJadwal').addClass('active');
            $('#prodiDataJadwal').addClass('active');
		} else if (uri == 'kelas') { 
            $('#prodiJadwal').addClass('active');
			$('#prodiKelas').addClass('active');
		} else if (uri == 'kategori') {
            $('#prodiUraian').addClass('active');
			$('#prodiKategori').addClass('active');
		} else if (uri == 'uraian') {
            $('#prodiUraian').addClass('active');
            $('#prodiUraianKinerja').addClass('active');
		} else if (uri == 'loss') {
            $('#prodiInput').addClass('active');
    }
</script>