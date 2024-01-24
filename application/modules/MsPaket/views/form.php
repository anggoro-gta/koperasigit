<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Cabang</h3>
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
              <form action="<?= $action; ?>" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" autocomplete='off'>
                <div class="form-group required">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Nama Paket</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="nama_paket" required class="form-control col-md-7 col-xs-12 upper" value="<?=$nama_paket?>">
                    </div>
                </div>
                <div class="form-group required">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Biaya</label>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <input type="text" name="nominal" required class="form-control col-md-7 col-xs-12 nominal" value="<?=$nominal?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Fee Terapis</label>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <input type="text" name="fee_terapis" class="form-control col-md-7 col-xs-12 nominal" value="<?=$fee_terapis?>">
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