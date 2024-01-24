<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>User</h3>
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
          <form action="<?= $action; ?>" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
            <div class="form-group required">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Username
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="username" name="username" required class="form-control col-md-7 col-xs-12" value="<?=$username?>">
              </div>
            </div>
            <?php if(empty($id)):?>
            <div class="form-group required">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Password
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="password" name="password" required class="form-control col-md-7 col-xs-12" value="<?=$password?>">
              </div>
            </div>
            <?php endif; ?>
            <div class="form-group required">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Nama Lengkap
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="nama_lengkap" name="nama_lengkap" required class="form-control col-md-7 col-xs-12 upper" value="<?=$nama_lengkap?>">
              </div>
            </div>
            <div class="form-group required">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Level</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" tabindex="-1" id="fk_level_id" name="fk_level_id" required>
                  <option value="">.: Pilih :.</option>
                  <?php foreach ($arrLevel as $val) { ?>
                      <option <?=$fk_level_id==$val['id']?'selected':''?> value="<?=$val['id']?>"><?=$val['nama']?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Cabang</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" tabindex="-1" id="fk_cabang_id" name="fk_cabang_id">
                  <option value="">.: Pilih :.</option>
                  <?php foreach ($arrCabang as $val2) { ?>
                      <option <?=$fk_cabang_id==$val2['id']?'selected':''?> value="<?=$val2['id']?>"><?=$val2['nama_cabang']?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group required">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Kode
              </label>
              <div class="col-md-2 col-sm-6 col-xs-12">
                <input type="text" id="kode_pj" name="kode_pj" required class="form-control col-md-7 col-xs-12 upper text-center" value="<?=$kode_pj?>" maxlength='2' minlength='2'>
              </div>
            </div>
            <div class="form-group required">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Blokir
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <label class="radio-inline">
                  <input id="inlineRadio1" name="blokir" value="Y" type="radio" <?php echo $blokir=='Y'?'checked':'';?> >
                              Ya
                </label>
                <label class="radio-inline">
                    <input id="inlineRadio2" name="blokir" value="N" type="radio" <?php echo $blokir!='Y'?'checked':'';?> >
                              Tidak
                </label>
              </div>
            </div>
            <?php if($id):?>
            <div class="form-group required">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Reset Password
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="input-group">
                    <div class="col-md-1">
                        <input name="reset_password" id="reset_password" type="checkbox">
                        <span id="info_pswd" class="label-success label label-default">Password awal : 123456</span>
                    </div>
                </div>
              </div>
            </div>
            <?php endif;?>
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
<script type="text/javascript">
$(document).ready(function(){
    $('#info_pswd').hide();
    $("#reset_password").click(function(){
        if ($('#reset_password').is(':checked')) {
            $('#info_pswd').show();
        }else{
            $('#info_pswd').hide();
        }
    });
});
</script>