<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Pelanggan</h3>
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
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Error!</strong> <?php echo $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>
          <div class="x_panel">
            <div class="x_title">
              <ul class="nav navbar-left panel_toolbox">
                <div class="pull-left">
                  <a href="<?= $act_back?>" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-chevron-left"></i> kembali</a>
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
                                  <option <?=$fk_cabang_id==$val['id']?'selected':''?> value="<?=$val['id']?>"><?=$val['nama_cabang']?></option>
                              <?php } ?>
                          </select>
                    </div>
                </div> -->
                <div class="form-group required">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Nama</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="nama" required class="form-control col-md-7 col-xs-12 upper" value="<?=$nama?>">
                    </div>
                </div>
                <div class="form-group required">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">No. HP</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="no_hp" required class="form-control col-md-7 col-xs-12" value="<?=$no_hp?>" placeholder="jika tidak punya no HP maka diisi (-) / Strip">
                    </div>
                </div>
                <div class="form-group required">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Jenis Kelamin</label>
                    <div class="col-md-2 col-sm-1 col-xs-3">
                        <select name="jenis_kel" id="jenis_kel" class="form-control col-md-7 col-xs-12" required>
                          <option value="">.: Pilih :.</option>
                          <option <?=$jenis_kel=='L'?'selected':''?> value="L">Laki-laki</option>
                          <option <?=$jenis_kel=='P'?'selected':''?> value="P">Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Alamat</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="alamat" class="form-control col-md-7 col-xs-12" value="<?=$alamat?>">
                    </div>
                </div>
                <div class="form-group required">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Status</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <label class="radio-inline">
                        <input id="inlineRadio1" name="status" value="1" type="radio" <?php echo $status=='1'?'checked':'';?> >
                                    Aktif
                      </label>
                      <label class="radio-inline">
                          <input id="inlineRadio2" name="status" value="0" type="radio" <?php echo $status=='0'?'checked':'';?> >
                                    Tidak Aktif
                      </label>
                    </div>
                </div>

                <input type="hidden" name="id" value="<?=$id?>">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="reset" class="btn btn-primary">Batal</button>
                    <button type="submit" class="btn btn-success"><?= $button?></button>
                </div>
              </form>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>