<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3><?= $judul ?></h3>
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

      <div class="x_content">
        <br />

        <form target="_blank" action="<?= $action ?>" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" autocomplete='off'>
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

                  </div>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <br />
                <div class="form-group required">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Jenis</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control" name="jenis" id="jenis" required>
                      <option value="">.: Pilih :.</option>
                      <option value="1">Rekap</option>
                      <option value="2">Rincian</option>
                    </select>
                  </div>
                </div>
                <div class="form-group required fk_skpd_id">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Dinas</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control" name="fk_skpd_id" id="fk_skpd_id" required>
                      <option value="">.: Pilih :.</option>
                      <?php foreach ($arrSKPD as $skpd) { ?>
                        <option value="<?= $skpd['id'] ?>"><?= $skpd['nama_skpd'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <button type="submit" class="btn btn-danger" name="type" value="pdf"><i class="glyphicon glyphicon-file"></i> Cetak PDF</button>
                  <button type="submit" class="btn btn-success" name="type" value="excel"><i class="glyphicon glyphicon-download"></i> Download ExcelF</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    $('.fk_skpd_id').hide()
  })
  $("#jenis").change(function() {
    id = $('#jenis').val()
    if (id == 1) {
      $('.fk_skpd_id').hide()
      $('#fk_skpd_id').attr('required', false)
    } else {
      $('.fk_skpd_id').show()
      $('#fk_skpd_id').attr('required', true)

    }
  });
</script>