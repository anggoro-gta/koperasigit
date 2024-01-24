<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>Ubah Password</h3>
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
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Sukses!</strong> <?php echo $this->session->flashdata('success') ?>
            </div>
        <?php elseif($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Error!</strong> <?php echo $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>
        <div class="x_panel">
            <div class="x_title">
              <ul class="nav navbar-right panel_toolbox">
                <div class="pull-right">
                  <!-- <a onclick="window.history.back()" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-chevron-left"></i> kembali</a> -->
                </div>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <br />
              <form action="<?=base_url()?>Users/ubahPswd" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                <div class="form-group required">
                  <label class="control-label col-md-2" for="last-name">Username</label>
                  <div class="col-md-3">
                        <input class="form-control" value="<?=$this->session->username?>" readonly></input>
                  </div>
                </div>
                <div class="form-group required">
                    <label class="col-md-2 control-label">Password Lama</label>
                    <div class="col-md-3">
                         <input type="text" id="pswdLama" name="pswdLama" class="form-control" value="<?=$pswdLama?>" required></input>
                    </div>
                </div>
                <div class="form-group required">
                    <label class="col-md-2 control-label">Password Baru</label>
                    <div class="col-md-3">
                         <input type="text" id="pswdBaru" name="pswdBaru" class="form-control" value="<?=$pswdBaru?>" required></input>
                    </div>
                </div>
                <div class="form-group required">
                    <label class="col-md-2 control-label">Ulangi Password Baru</label>
                    <div class="col-md-3">
                         <input type="text" id="pswdLama" name="ulangiPswdBaru" class="form-control" value="<?=$ulangiPswdBaru?>" required></input>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" class="btn btn-success"> Update</button>
                </div>
              </form>
              </div>
        </div>
      </div>
    </div>
  </div>
</div>