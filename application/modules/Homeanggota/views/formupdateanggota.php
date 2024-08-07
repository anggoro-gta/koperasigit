<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Updata Data Anggota</h3>
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

                        </div>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <form action="<?= $action; ?>" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" autocomplete='off'>

                        <div class="form-group required">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Status Pekerjaan</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select class="form-control" name="fk_id_status_pekerjaan" id="fk_id_status_pekerjaan" required>
                                    <option value="">.: Pilih :.</option>
                                    <?php foreach ($arrPekerjaan as $pekerjaan) { ?>
                                        <option value="<?= $pekerjaan['id'] ?>" <?= $pekerjaan['id'] == $fk_id_status_pekerjaan ? 'selected' : '' ?>><?= $pekerjaan['status_pekerjaan'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group required">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Nama</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="nama" required class="form-control col-md-7 col-xs-12" value="<?= $nama ?>" minlength="5">
                            </div>
                        </div>
                        <div class="form-group required">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">NIK</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="nik" required class="form-control col-md-7 col-xs-12 angka" value="<?= $nik ?>" minlength="16" maxlength="16">
                            </div>
                        </div>
                        <div class="form-group required">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">NIP</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input <?= in_array($fk_id_status_pekerjaan, [3, 4]) ? 'readonly' : '' ?> minlength="18" maxlength="18" type="text" name="nip" id="nip" required class="form-control col-md-7 col-xs-12 <?= in_array($fk_id_status_pekerjaan, [1, 2]) ? 'angka' : '' ?>" value="<?= $nip ?>">
                            </div>
                        </div>
                        <div class="form-group required">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">No. HP</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="nomor_hp" required class="form-control col-md-7 col-xs-12 angka" value="<?= $nomor_hp ?>" minlength="11" maxlength="13">
                            </div>
                        </div>
                        <div class="form-group required">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Alamat (Sesuai KTP)</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="alamat" required class="form-control col-md-7 col-xs-12" value="<?= $alamat ?>" minlength="10">
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
<script>
    $("#fk_id_status_pekerjaan").change(function() {
        v = $(this).val()
        if (['1', '2'].includes(v)) {
            $('#nip').attr('readonly', false)
            $('#nip').val('')
            $("#nip").keypress(function(data) {
                if (data.which != 8 && data.which != 0 && (data.which < 48 || data.which > 57)) {
                    return false;
                }
            });
        } else {
            $('#nip').val('-')
            $('#nip').attr('readonly', true)
            $('#nip').removeClass('angka')
        }
    });
</script>