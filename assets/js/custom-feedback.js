$(document).ready(function(){
    $('.tambah-perusahaan').hide();
    $('.data-perusahaan').hide();
    $('.data-wirausaha').hide();

    $('.addFormPosisi').prop('required', false);
    $('.addFormBulan').prop('required', false);
    $('.addFormTahun').prop('required', false);

    $(document).on('click', '#btn-hapus-kategori', function(e){
        var kategori = $(this).data('kategori');
        var urutan = $(this).data('urutan');

        $('#urutanHapus').val(urutan);


        $('.output').html(
            "Apakah anda yakin akan menghapus data dengan kategori = "+
            "<strong>"+kategori+"</strong>"
        );
    });

    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });

    $('#tbl-hello').DataTable({
        'dom' : "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'<'pull-right'p>>>",
      });
    
});

$('input:radio[name="kd_status"]').change(
    function(){
        if ($(this).val() == '1') {
            $('.data-perusahaan').show();
            $('.data-wirausaha').hide();
            // $('.addFormPosisi').prop('required', true);
            // $('.addFormBulan').prop('required', true);
            // $('.addFormTahun').prop('required', true);
        } else if ($(this).val() == '2') {
            $('.data-wirausaha').show();
            $('.data-perusahaan').hide();
            // $('.addFormPosisi').prop('required', true);
            // $('.addFormBulan').prop('required', true);
            // $('.addFormTahun').prop('required', true);
        } else {
            $('.data-perusahaan').hide();
            $('.data-perusahaan')
                .find("input,textarea,select")
                    .val('')
                    .end();
            // $('.addFormPosisi').prop('required', false);
            // $('.addFormBulan').prop('required', false);
            // $('.addFormTahun').prop('required', false);

            $('.data-wirausaha').hide();
            $('.data-wirausaha')
                .find("input,textarea,select")
                    .val('')
                    .end();
        }
    });

// TOGGLE FORM ADD PERUSAHAAN
$('.btn-perusahaan').click(function(){
    $('.tambah-perusahaan').slideToggle();
    $('.tambah-perusahaan')
          .find("input,textarea,select")
             .val('')
             .end();
});

// ALERT AUTOCLOSED
window.setTimeout(function() {
    $(".alert.alert-success").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove();
        $( "br" ).remove();
        $( "br" ).remove();
    });
    $(".alert.alert-warning").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove();
        $( "br" ).remove();
        $( "br" ).remove();
    });
    $(".alert.alert-danger").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove();
    });
}, 3000);

// CHECK NPM AVAILABLE OR NOT
function check_npm()
{
    var npm = $('#npm-alumni').val();

    $.ajax({
        method: "post",
        url: baseurl+"feedbackajax/checkNpm",
        data: {npm: npm},
        success: function(res){
            if (res == 1) {
                $('#status-npm').html("<p class='text-danger'><i class='fa fa-remove'></i> NPM sudah digunakan!!!</p>");
                $('#btn-add-mhs').prop('disabled', true);
                $('#npm-prodi-group').removeClass('has-success');
                $('#npm-prodi-group').addClass('has-error');
            } else {
                $('#status-npm').html("<p class='text-success'><i class='fa fa-check'></i> NPM tersedia!!!</p>");
                $('#btn-add-mhs').prop('disabled', false);
                $('#npm-prodi-group').removeClass('has-error');
                $('#npm-prodi-group').addClass('has-success');
            }
        }
    });
}

$(document).on('click', '#btnEditPerusahaan', function(e){
    e.preventDefault();

    let data = $(this).data();

    $.ajax({
      method: 'post',
      url: baseurl+'feedbackajax/getPerusahaan',
      async: true,
      dataType: 'json',
      data: {kd_perusahaan:data['perusahaan']},
      success: function(res){
        $('#ptEditNama').val(res[0]['nama_perusahaan']);
        $('#ptEditAlamat').val(res[0]['alamat']);
        $('#ptEditBidangUsaha').val(res[0]['bidang_usaha']);
        $('#ptEditEmail').val(res[0]['email']);
        $('#ptEditKode').val(res[0]['kd_perusahaan']);

        // $('#baaEditMatkulSks option').filter(function(){
        //   return ($(this).val() == res[0]['sks']);
        // }).prop('selected', true);

      }
    });
});

$(document).on('click', '#btnEditAlumni', function(e){
    e.preventDefault();

    let data = $(this).data();

    $.ajax({
      method: 'post',
      url: baseurl+'feedbackajax/getAlumni',
      async: true,
      dataType: 'json',
      data: {npm:data['npm']},
      success: function(res){
          console.log(res[0]['tahun_bekerja']);
        $('#alumniEditNpm').val(res[0]['npm']);
        $('#alumniEditNama').val(res[0]['nama']);
        $('#alumniEditAlamat').val(res[0]['alamat']);
        $('#alumniEditTlp').val(res[0]['no_tlp']);
        $('#alumniEditEmail').val(res[0]['email']);
        $('#alumniEditTahun').val(res[0]['thn_lulus']);
        $('#alumniEditPosisi').val(res[0]['posisi']);
        $('#alumniEditTahunBekerja').val(res[0]['tahun_bekerja']);

        $('#alumniEditPt option').filter(function(){
          return ($(this).val() == res[0]['kd_perusahaan']);
        }).prop('selected', true);

        $('#alumniEditBulan option').filter(function(){
            return ($(this).val() == res[0]['bulan_bekerja']);
          }).prop('selected', true);

      }
    });
});






