<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>Laporan Transaksi</h3>
    </div>

    <div class="title_right">
      <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
        <div class="input-group">
        </div>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">

          <ul class="nav navbar-left panel_toolbox">
            <div class="pull-left">
              <a onclick="window.history.back()" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-chevron-left"></i> kembali</a>
            </div>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <br />
          <form action="<?= $action; ?>" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" target="_blank" autocomplete="off">
            <div class="form-group required">
              <label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">Tanggal</label>
              <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="input-group">
                  <input type="text" name="tgl_dari" id="tgl_dari" required class="form-control col-md-2 col-xs-10 tanggal text-center">
                  <span class="input-group-addon"><b>s/d</b></span>
                  <input type="text" name="tgl_sampai" id="tgl_sampai" required class="form-control col-md-2 col-xs-10 tanggal text-center">
                </div>
              </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-12">Cabang</label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <select class="form-control" name="fk_cabang_id" id="fk_cabang_id">
                        <option value="">.: Pilih :.</option>
                        <?php foreach ($arrcabang as $val) { ?>
                            <option value="<?=$val['id']?>"><?=$val['nama_cabang']?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-12">Pelanggan</label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <select class="form-control" name="fk_pelanggan_id" id="fk_pelanggan_id">
                        <option value="">.: Pilih :.</option>
                        <?php foreach ($arrPelanggan as $valP) { ?>
                            <option value="<?=$valP['id']?>"><?=$valP['nama'].' ('.$valP['no_hp'].')'?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-12">Terapis</label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <select class="form-control" name="fk_terapis_id" id="fk_terapis_id">
                        <option value="">.: Pilih :.</option>
                        <?php foreach ($arrTerapis as $valT) { ?>
                            <option value="<?=$valT['id']?>"><?=$valT['nama_lengkap']?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
          </div>

            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button type="reset" class="btn btn-primary">Batal</button>
                <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-file"></i> Cetak PDF</button>
                <a title="Download Excel" class="btn btn-md btn-warning" id="cetakExcel" ><i class="glyphicon glyphicon-download"></i> Download Excel</a>
            </div>
          </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$("#cetakExcel").click(function(){
    tgl_dari = $("#tgl_dari").val();
    if(tgl_dari==''){
      alert('Tanggal Harus Diisi semua.');
      return false;
    }
    tgl_sampai = $("#tgl_sampai").val();
    if(tgl_sampai==''){
      alert('Tanggal Harus Diisi semua.');
      return false;
    }

    fk_cabang_id = $("#fk_cabang_id").val();
    fk_pelanggan_id = $("#fk_pelanggan_id").val();
    fk_terapis_id = $("#fk_terapis_id").val();

    window.location.href="<?= base_url()?>Laporan/excel_transaksi?tgl_dari="+tgl_dari+'&tgl_sampai='+tgl_sampai+'&fk_cabang_id='+fk_cabang_id+'&fk_pelanggan_id='+fk_pelanggan_id+'&fk_terapis_id='+fk_terapis_id;
});
</script>