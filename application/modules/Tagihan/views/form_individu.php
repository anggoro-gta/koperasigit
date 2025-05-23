<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>Tagihan Individu</h3>
    </div>

    <div class="title_right">
      <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
        <div class="input-group"></div>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
  <div class="row">
    <form action="<?= $action; ?>" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" autocomplete='off'>
      <div class="col-md-12 col-sm-12 col-xs-12">

        <?php if ($this->session->flashdata('success')) : ?>
          <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Sukses!</strong> <?php echo $this->session->flashdata('success') ?>
          </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')) : ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> <?php echo $this->session->flashdata('error') ?>
          </div>
        <?php endif; ?>
        <div class="x_panel">
          <div class="x_title">
            <ul class="nav navbar-left panel_toolbox">
              <div class="pull-left">
                <a href="<?= $act_back ?>" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-chevron-left"></i> kembali</a>
              </div>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />

            <div class="form-group required">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Tagihan Bulan</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input <?= $disable ?> type="text" name="periode" required class="form-control col-md-7 col-xs-12 blnThn" value="<?= $periode ?>">
              </div>
            </div>
            <?php if ($method == 'POST') { ?>
              <div class="form-group required">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Jenis</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control" name="jenis" id="jenis" required>
                    <option value="">.: Pilih :.</option>
                    <option value="1">Tagihan Pinjaman</option>
                    <option value="2">Tagihan Simpanan</option>
                    <option value="3">Tagihan Pinjaman & Simpanan</option>
                    <option value="4">Tagihan Pinjaman Kompensasi</option>
                    <option value="5">Tagihan Pinjaman Pelunasan</option>
                  </select>
                </div>
              </div>
            <?php } ?>
            <div class="form-group required">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Dinas</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select <?= $disable ?> class="form-control" name="fk_skpd_id" id="fk_skpd_id" required>
                  <option value="">.: Pilih :.</option>
                  <?php foreach ($arrSKPD as $skpd) { ?>
                    <option <?= $fk_skpd_id == $skpd['id'] ? 'selected' : '' ?> value="<?= $skpd['id'] ?>"><?= $skpd['nama_skpd'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group required">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Anggota</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select <?= $disable ?> class="form-control" name="fk_anggota_id" id="fk_anggota_id" required>
                  <option value="">.: Pilih :.</option>

                </select>
              </div>
            </div>
            <input type="hidden" name="id" value="<?= $id ?>">
          </div>
        </div>
      </div>
      <div id="tampilData">

      </div>
      <?php if ($method == 'POST') { ?>
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
          <button type="submit" class="btn btn-success"><?= $button ?></button>
        </div>
      <?php } ?>

      <?php if (in_array($this->session->userdata('fk_cb_level_id'), [1, 3]) && $method == 'PUT') : ?>
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
          <a onclick="return confirm('Apakah Anda akan <?= $label_posting ?> data?');" href="<?= base_url() ?>Tagihan/posting/<?= $id ?>" class="btn btn-primary"><?= $label_posting ?></a>
        </div>
      <?php endif; ?>
    </form>
  </div>
</div>
</div>
<script>
  $("#fk_skpd_id").change(function() {
    fk_skpd_id = $(this).val();
    $.ajax({
      type: "POST",
      dataType: "json",
      url: "<?php echo base_url() . 'Tagihan/getAnggota' ?>",
      data: {
        fk_skpd_id
      },
      success: function(msg) {
        $('#fk_anggota_id').html(msg.data).val('<?= $fk_anggota_id ?? '' ?>').trigger('change');
      }
    });
  });


  <?php if ($method == 'POST') : ?>
    $(document).on('change', '#fk_anggota_id', function() {
      let fk_anggota_id = $('#fk_anggota_id').val()
      if (fk_anggota_id != '') {
        loadDetail()
      }
    });
  <?php endif; ?>

  function loadDetail(id) {
    if (id) {
      url = "<?php echo base_url() ?>Tagihan/getDataIndividu/" + id;
    } else {
      url = "<?php echo base_url() ?>Tagihan/getDataIndividu";
    }
    let fk_anggota_id = $('#fk_anggota_id').val()
    let jenis = $('#jenis').val()
    $.ajax({
      type: 'post',
      url: url,
      data: {
        fk_anggota_id,
        jenis,
      },
      beforeSend: function() {
        $("body").css("cursor", "progress");
      },
      success: function(data) {
        $("body").css("cursor", "default");
        $("#tampilData").html(data);
      }
    });
  }

  $(document).on('change', '#jenis', function() {

    $("#tampilData").html('');
    $('#fk_anggota_id').val('').trigger("change")
    $('#fk_skpd_id').val('').trigger("change")

  })
  $(document).on('change', '#angsuran_ke', function() {
    let angsuran_ke = $('#angsuran_ke').val(),
      min_angsuran = $('#min_angsuran').val(),
      max_angsuran = $('#max_angsuran').val();
    if (parseInt(angsuran_ke) < (min_angsuran)) {
      alert('ke harus lebih dari ' + min_angsuran)
      $('#angsuran_ke').val(min_angsuran)
      hitung(1)
      return false;
    }
    if (parseInt(angsuran_ke) > (max_angsuran)) {
      alert('ke harus kurang dari ' + max_angsuran)
      $('#angsuran_ke').val(min_angsuran)
      hitung(1)
      return false;
    }
    hitung(angsuran_ke - min_angsuran + 1)

  });

  $(document).on('change', '#label_tapim', function() {
    let angsuran_ke = $('#angsuran_ke').val(),
      min_angsuran = $('#min_angsuran').val(),
      max_angsuran = $('#max_angsuran').val();
    hitung_pelunasan(angsuran_ke - min_angsuran + 1);
  });

  $(document).on('change', '#label_bunga', function() {
    let angsuran_ke = $('#angsuran_ke').val(),
      min_angsuran = $('#min_angsuran').val(),
      max_angsuran = $('#max_angsuran').val();
    hitung_pelunasan(angsuran_ke - min_angsuran + 1);
  });

  function hitung_pelunasan(x) {
    let const_pokok = $('#const_pokok').val(),
      const_tapim_count = $('#label_tapim').val(),
      const_bunga_count = $('#label_bunga').val(),
      const_tapim = $('#const_tapim').val(),
      const_bunga = $('#const_bunga').val(),
      const_jml_tagihan = $('#const_jml_tagihan').val();

    const_tapim_remove_koma = const_tapim_count.replace(/,/g, "");
    const_bunga_remove_koma = const_bunga_count.replace(/,/g, "");

    const_tapim_count_number = parseInt(const_tapim_remove_koma);
    const_bunga_count_number = parseInt(const_bunga_remove_koma);

    const_pokok_count = $('#pokok').val();

    const_pokok_count_number = parseInt(const_pokok_count);

    console.log(const_pokok_count_number + const_tapim_count_number + const_bunga_count_number);

    $('#label_pokok').html(numberWithCommas(x * const_pokok));
    $('#label_tapim').html(numberWithCommas(x * const_tapim));
    $('#label_bunga').html(numberWithCommas(x * const_bunga));
    $('#label_jml_tagihan').html(numberWithCommas(const_pokok_count_number + const_tapim_count_number + const_bunga_count_number));
    $('#pokok').val(x * const_pokok);
    $('#tapim').val(const_tapim_count_number);
    $('#bunga').val(const_bunga_count_number);
    $('#jml_tagihan').val(const_pokok_count_number + const_tapim_count_number + const_bunga_count_number);
  }

  function hitung(x) {
    let const_pokok = $('#const_pokok').val(),
      const_tapim = $('#const_tapim').val(),
      const_bunga = $('#const_bunga').val(),
      const_jml_tagihan = $('#const_jml_tagihan').val()
    console.table(const_pokok, x, x * const_pokok);
    $('#label_pokok').html(numberWithCommas(x * const_pokok))
    $('#label_tapim').html(numberWithCommas(x * const_tapim))
    $('#label_bunga').html(numberWithCommas(x * const_bunga))
    $('#label_jml_tagihan').html(numberWithCommas(x * const_jml_tagihan))
    $('#pokok').val(x * const_pokok)
    $('#tapim').val(x * const_tapim)
    $('#bunga').val(x * const_bunga)
    $('#jml_tagihan').val(x * const_jml_tagihan)
  }

  $(document).ready(function() {
    <?php if ($id) { ?>
      loadDetail(<?= $id ?>)
      $('#fk_skpd_id').trigger('change');
    <?php } ?>
  });
</script>