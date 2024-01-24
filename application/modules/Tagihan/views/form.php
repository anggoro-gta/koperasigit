<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>Simpanan</h3>
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
                    <option <?= $fk_anggota_id == $valanggota['id'] ? 'selected' : '' ?> value="<?= $valanggota['id'] ?>"><?= $valanggota['nama'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group required">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Tanggal</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="tgl" required class="form-control col-md-7 col-xs-12 tanggal" value="<?= $tgl ?>">
              </div>
            </div>
            <div class="form-group required">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Wajib</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="wajib" required class="form-control col-md-7 col-xs-12 nominal" value="<?= $wajib ?>">
              </div>
            </div>
            <div class="form-group required">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Sukarela</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="sukarela" required class="form-control col-md-7 col-xs-12 nominal" value="<?= $sukarela ?>">
              </div>
            </div>

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