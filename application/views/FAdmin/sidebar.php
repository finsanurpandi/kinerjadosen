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
        <p>Alexander Pierce</p>
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
        <a href="<?=base_url()?>feedbackadmin">
          <i class="fa fa-th"></i> <span>Dashboard</span>
        </a>
      </li>
      <li id="prodiJadwal" class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>Master Data</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li id="prodiDataJadwal"><a href="<?=base_url()?>feedbackadmin/alumni"><i class="fa fa-circle-o"></i> Data Alumni</a></li>
            <li id="prodiDataJadwal"><a href="<?=base_url()?>feedbackadmin/jmlalumni"><i class="fa fa-circle-o"></i> Jumlah Alumni</a></li>
            <li id="prodiKelas"><a href="<?=base_url()?>feedbackadmin/perusahaan"><i class="fa fa-circle-o"></i> Perusahaan</a></li>
            <li id="prodiKelas"><a href="<?=base_url()?>feedbackadmin/uraian"><i class="fa fa-circle-o"></i> Uraian Penilaian</a></li>
          </ul>
        </li>
        <li id="prodiUraian" class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>Hasil Penilaian</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li id="prodiKategori"><a href="<?=base_url()?>feedbackadmin/penilaian_alumni"><i class="fa fa-circle-o"></i> Alumni</a></li>
            <li id="prodiUraianKinerja"><a href="<?=base_url()?>feedbackadmin/penilaian_perusahaan"><i class="fa fa-circle-o"></i> Perusahaan</a></li>
          </ul>
        </li>
        <li id="prodiKinerja">
        <a href="<?=base_url()?>feedbackadmin/cetak">
          <i class="fa fa-th"></i> <span>Cetak Laporan</span>
        </a>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>

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
		};
</script>