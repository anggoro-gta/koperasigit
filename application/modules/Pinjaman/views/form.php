<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>Pinjaman</h3>
    </div>

    <div class="title_right">
      <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
        <div class="input-group"></div>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
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
          <form action="<?= $action; ?>" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" autocomplete='off'>
            <!-- <div class="form-group required">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Cabang</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control" name="fk_cabang_id" id="fk_cabang_id" required>
                              <option value="">.: Pilih :.</option>
                              <?php foreach ($arrcabang as $val) { ?>
                                  <option <?= $fk_cabang_id == $val['id'] ? 'selected' : '' ?> value="<?= $val['id'] ?>"><?= $val['nama_cabang'] ?></option>
                              <?php } ?>
                          </select>
                    </div>
                </div> -->

            <div class="form-group required">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Anggota</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="fk_anggota_id" id="fk_anggota_id" required>
                  <option value="">.: Pilih :.</option>
                  <?php foreach ($arrUserAnggota as $valanggota) { ?>
                    <option <?= $fk_anggota_id == $valanggota['id'] ? 'selected' : '' ?> value="<?= $valanggota['id'] ?>"><?= $valanggota['nama'] . ' (' . $valanggota['nama_skpd'] . ')' ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group required">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Kategori</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="fk_kategori_id" id="fk_kategori_id" required>
                  <option value="">.: Pilih :.</option>
                  <?php foreach ($arrKategori as $valkategori) { ?>
                    <option <?= $fk_kategori_id == $valkategori['id'] ? 'selected' : '' ?> value="<?= $valkategori['id'] ?>"><?= $valkategori['kategori'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group required">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Tanggal Pinjam</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="tgl_mulai_hutang" required class="form-control col-md-7 col-xs-12 tanggal" value="<?= $tgl_mulai_hutang ?>">
              </div>
            </div>
            <div class="form-group required">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Jumlah Pinjaman</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="jml_pinjam" id="idjml_pinjam" required class="form-control col-md-7 col-xs-12 nominal" value="<?= $jml_pinjam ?>">
              </div>
            </div>
            <div class="form-group required">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Jumlah Angsuran / Tenor</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="tenor" id="idtenor" required class="form-control col-md-7 col-xs-12 angka" value="<?= $tenor ?>">
              </div>
            </div>
            <div class="form-group required non_palen">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Pembulatan Pinjaman</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="bulat_pinjam" id="idbulat_pinjam" required class="form-control col-md-7 col-xs-12 nominal" readonly value="<?= $bulat_pinjam ?>">
              </div>
            </div>
            <div class="form-group required">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Pokok</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="pokok" id="idpokok" required class="form-control col-md-7 col-xs-12 nominal" readonly value="<?= $pokok ?>">
              </div>
            </div>
            <div class="form-group required non_palen">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Tapim</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="tapim" id="idtapim" required class="form-control col-md-7 col-xs-12 nominal" readonly value="<?= $tapim ?>">
              </div>
            </div>
            <div class="form-group required">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Bunga</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="bunga" id="idbunga" required class="form-control col-md-7 col-xs-12 nominal" readonly value="<?= $bunga ?>">
              </div>
            </div>
            <div class="form-group required">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Jumlah Tagihan</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="jml_tagihan" id="idjml_tagihan" required class="form-control col-md-7 col-xs-12 nominal" readonly value="<?= $jml_tagihan ?>">
              </div>
            </div>

            <input type="hidden" name="nilaibunga" id="idnilaibunga" value="<?= $nilaibunga ?>">
            <input type="hidden" name="id" value="<?= $id ?>">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
              <button type="reset" class="btn btn-primary">Batal</button>
              <button type="submit" class="btn btn-success"><?= $button ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<script type="text/javascript">
  $("#fk_kategori_id").change(function() {
    idkategori = $(this).val();

    $(".non_palen").show();
    $('#idtenor').prop('readonly', false);
    $('#idpokok').prop('readonly', true);
    $('#idbunga').prop('readonly', true);
    $('#idtenor').val('');
    if (idkategori == 1) {
      $('#idbunga').prop('readonly', false);
    }
    if (idkategori == 3) {
      $(".non_palen").hide();
      $('#idtenor').val(1);
      $('#idtenor').prop('readonly', true);
      $('#idpokok').prop('readonly', false);
      $('#idbunga').prop('readonly', false);
    }
    $.ajax({
      type: "POST",
      url: "<?php echo base_url() . 'Pinjaman/cariBunga' ?>",
      data: {
        idkategori
      },
      dataType: 'json',
      success: function(msg) {
        $('#idnilaibunga').val(msg.bunga);
      }
    });
  });

  $("#idjml_pinjam").keyup(function() {
    if ($('#idtenor').val() != '') {
      if (idkategori == 1) {
        hitungJml();
      } else if (idkategori == 2) {
        hitungJml();
      } else if (idkategori == 3) {
        hitungJmlPalen();
      }
    }
  });

  $("#idtenor").keyup(function() {
    if (idkategori == 1) {
      hitungJml();
    } else if (idkategori == 2) {
      hitungJml();
    } else if (idkategori == 3) {
      hitungJmlPalen();
    }
  });

  $("#idpokok").keyup(function() {
    if (idkategori == 1) {
      hitungJml();
    } else if (idkategori == 2) {
      hitungJml();
    } else if (idkategori == 3) {
      hitungJmlPalen();
    }
  });

  $("#idbunga").keyup(function() {
    if (idkategori == 1) {
      hitungJmlbungamanual();
    } else if (idkategori == 2) {
      hitungJml();
    } else if (idkategori == 3) {
      hitungJmlPalen();
    }
  });

  function hitungJmlPalen() {
    jumlah_pinjam = $('#idjml_pinjam').val();
    jumlah_pinjam_replace = jumlah_pinjam.replaceAll(",", "");
    jml_pokok = $('#idpokok').val();
    jml_pokok_replace = jml_pokok.replaceAll(",", "");
    jumlah_bunga = $('#idbunga').val();
    jumlah_bunga_replace = jumlah_bunga.replaceAll(",", "");

    // tot = parseInt(jumlah_pinjam_replace) + parseInt(jml_pokok_replace) + parseInt(jumlah_bunga_replace);
    tot = parseInt(jml_pokok_replace) + parseInt(jumlah_bunga_replace);
    $('#idjml_tagihan').val(tot);
  }

  function hitungJml() {
    fk_kategori_id = $('#fk_kategori_id').val();
    jumlah_pinjam = $('#idjml_pinjam').val();
    jumlah_pinjam_replace = jumlah_pinjam.replaceAll(",", "");
    angkajumlah_pinjam_replace = Math.round(jumlah_pinjam_replace);

    jumlah_angsuran = $('#idtenor').val();

    total_tagihan = jumlah_pinjam_replace / jumlah_angsuran;
    pembulatan_total_tagihan = Math.round(total_tagihan);
    stringpembulatan_total_tagihan = pembulatan_total_tagihan.toString();

    get3laststring = stringpembulatan_total_tagihan.slice(-3);
    get2laststring = stringpembulatan_total_tagihan.slice(-2);

    sukubunga = $('#idnilaibunga').val();

    let hasil = 0;
    let kelipatanseribu = 0;
    for (let i = 0; i <= 30; i++) {
      kelipatanseribu = kelipatanseribu + 1000;
      if (get2laststring == "00" || get2laststring == "50" || get3laststring == "000") {
        hasil = angkajumlah_pinjam_replace;
        break;
      } else {
        plusseribu = angkajumlah_pinjam_replace + kelipatanseribu;
        plusseributagihan = plusseribu / jumlah_angsuran;
        pembulatan_plusseributagihan = Math.round(plusseributagihan);
        stringpembulatan_plusseributagihan = pembulatan_plusseributagihan.toString();

        plusseribu3laststring = stringpembulatan_plusseributagihan.slice(-3);
        plusseribu2laststring = stringpembulatan_plusseributagihan.slice(-2);
        if (plusseribu2laststring == "00" || plusseribu2laststring == "50" || plusseribu3laststring == "000") {
          hasil = plusseribu;
          break;
        }
      }
    }

    pokok = hasil / jumlah_angsuran;
    tapim = (10 / 100) * pokok;
    bunga = hasil * (sukubunga / 100);

    if (fk_kategori_id == 1) {
      hasil = jumlah_pinjam;
    }

    if (fk_kategori_id == 2) { //barang biar tapimnya 0
      tapim = 0;
      hasil = jumlah_pinjam;
    }

    if (fk_kategori_id == 3) { //tapim
      tapim = 0;
      pokok = 0;
      hasil = jumlah_pinjam;
    }
    jml_tagihan = pokok + tapim + bunga;

    $('#idbulat_pinjam').val(hasil);
    $('#idpokok').val(pokok);
    $('#idbunga').val(bunga);
    $('#idtapim').val(tapim);
    $('#idjml_tagihan').val(jml_tagihan);

  }

  //jumlah khusus bunga manual
  function hitungJmlbungamanual() {
    fk_kategori_id = $('#fk_kategori_id').val();
    jumlah_pinjam = $('#idjml_pinjam').val();
    jumlah_pinjam_replace = jumlah_pinjam.replaceAll(",", "");
    angkajumlah_pinjam_replace = Math.round(jumlah_pinjam_replace);

    jumlah_angsuran = $('#idtenor').val();

    total_tagihan = jumlah_pinjam_replace / jumlah_angsuran;
    pembulatan_total_tagihan = Math.round(total_tagihan);
    stringpembulatan_total_tagihan = pembulatan_total_tagihan.toString();

    get3laststring = stringpembulatan_total_tagihan.slice(-3);
    get2laststring = stringpembulatan_total_tagihan.slice(-2);

    sukubunga = $('#idnilaibunga').val();

    let hasil = 0;
    let kelipatanseribu = 0;
    for (let i = 0; i <= 30; i++) {
      kelipatanseribu = kelipatanseribu + 1000;
      if (get2laststring == "00" || get2laststring == "50" || get3laststring == "000") {
        hasil = angkajumlah_pinjam_replace;
        break;
      } else {
        plusseribu = angkajumlah_pinjam_replace + kelipatanseribu;
        plusseributagihan = plusseribu / jumlah_angsuran;
        pembulatan_plusseributagihan = Math.round(plusseributagihan);
        stringpembulatan_plusseributagihan = pembulatan_plusseributagihan.toString();

        plusseribu3laststring = stringpembulatan_plusseributagihan.slice(-3);
        plusseribu2laststring = stringpembulatan_plusseributagihan.slice(-2);
        if (plusseribu2laststring == "00" || plusseribu2laststring == "50" || plusseribu3laststring == "000") {
          hasil = plusseribu;
          break;
        }
      }
    }
  
    bunganumb = $('#idbunga').val();
    bunganumbreal = bunganumb.replaceAll(",", "");
    bungastringtonumb = parseInt(bunganumbreal);

    // console.log(bunganumbreal);

    pokok = hasil / jumlah_angsuran;
    tapim = (10 / 100) * pokok;
    bunga = bungastringtonumb;

    if (fk_kategori_id == 1) {
      hasil = jumlah_pinjam;
    }

    if (fk_kategori_id == 2) { //barang biar tapimnya 0
      tapim = 0;
      hasil = jumlah_pinjam;
    }

    if (fk_kategori_id == 3) { //tapim
      tapim = 0;
      pokok = 0;
      hasil = jumlah_pinjam;
    }
    jml_tagihan = pokok + tapim + bunga;

    $('#idbulat_pinjam').val(hasil);
    $('#idpokok').val(pokok);
    // $('#idbunga').val(bunga);
    $('#idtapim').val(tapim);
    $('#idjml_tagihan').val(jml_tagihan);

  }
</script>