<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>SHU - per OPD</h3>
        </div>

        <div class="title_right">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group"></div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <form action="<?= $action; ?>" method="post" id="demo-form2" data-parsley-validate
            class="form-horizontal form-label-left" autocomplete='off'>
            <div class="col-md-12 col-sm-12 col-xs-12">

                <?php if ($this->session->flashdata('success')) : ?>
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <strong>Sukses!</strong> <?php echo $this->session->flashdata('success') ?>
                </div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('error')) : ?>
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <strong>Error!</strong> <?php echo $this->session->flashdata('error') ?>
                </div>
                <?php endif; ?>
                <div class="x_panel">
                    <div class="x_title">
                        <ul class="nav navbar-left panel_toolbox">
                            <div class="pull-left">
                                <a href="<?= $act_back ?>" class="btn btn-sm btn-warning"><i
                                        class="glyphicon glyphicon-chevron-left"></i>
                                    kembali</a>
                                <?php if (in_array($this->session->userdata('fk_cb_level_id'), [1, 3]) && $method == 'PUT') : ?>
                                <a onclick="return confirm('Apakah Anda akan <?= $label_posting ?> data?');"
                                    href="<?= base_url() ?>SHU/Opd/posting/<?= $id ?>"
                                    class="btn btn-sm btn-success"><?= $label_posting ?></a>
                                <?php endif; ?>
                            </div>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <div class="form-group required">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Tahun</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="tahun" id="tahun" required
                                    class="form-control col-md-7 col-xs-12 tahun" <?= $disable ?> value="<?= $tahun ?>">
                            </div>
                        </div>
                        <div class="form-group required">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Dinas</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select <?= empty($arrSKPD) ? 'disabled' : $disable ?> class="form-control"
                                    name="fk_skpd_id" id="fk_skpd_id" required>
                                    <option value="">.: Pilih :.</option>
                                    <?php foreach ($arrSKPD as $skpd) { ?>
                                    <option <?= $fk_skpd_id == $skpd['id'] ? 'selected' : '' ?>
                                        value="<?= $skpd['id'] ?>"><?= $skpd['nama_skpd'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <?php if ($method == 'POST') { ?>
                            <a href="#" class="btn btn-primary" id="lihat_daftar"><i
                                    class="glyphicon glyphicon-search"></i> Tampilkan</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div id="tampilData">

            </div>
        </form>
    </div>
</div>
</div>
<script>
$('#tahun').on('keyup change', function() {
    loadSkpd($(this).val());
    $('#tampilData').html('')
});

function loadSkpd(tahun) {
    const $skpd = $('#fk_skpd_id');

    $.ajax({
        type: 'post',
        url: "<?= site_url('SHU/Opd/getSkpd') ?>",
        dataType: "json",
        data: {
            tahun
        },

        beforeSend: function() {
            // reset select2 UI ke placeholder
            $skpd.prop('disabled', true);

            $skpd.empty().append(new Option('Loading...', '', true, true));
            $skpd.val(null).trigger('change.select2'); // penting!
        },

        success: function(res) {
            // reset lagi ke "Pilih"
            $skpd.empty().append(new Option('.: Pilih :.', '', true, true));
            $skpd.val(null).trigger('change.select2');

            if (res.status && Array.isArray(res.result)) {
                res.result.forEach(item => {
                    $skpd.append(new Option(item.nama_skpd, item.id, false, false));
                });
            }

            // refresh select2 supaya daftar baru kebaca
            $skpd.trigger('change.select2');
            $skpd.prop('disabled', false);
        },

        error: function() {
            $skpd.empty().append(new Option('(Gagal load data)', '', true, true));
            $skpd.val(null).trigger('change.select2');
            $skpd.prop('disabled', false);
            alert('Gagal load data SKPD');
        }
    });
}


$(document).on('click', '#lihat_daftar', function() {
    let fk_skpd_id = $('#fk_skpd_id').val()
    if (fk_skpd_id == '') {
        alert('Pilih Dinas')
        return false
    }
    loadDetail()
});

function loadDetail(id) {
    if (id) {
        url = "<?php echo base_url() ?>SHU/Opd/getData/" + id;
    } else {
        url = "<?php echo base_url() ?>SHU/Opd/getData";
    }
    let fk_skpd_id = $('#fk_skpd_id').val()
    $.ajax({
        type: 'post',
        url: url,
        data: {
            fk_skpd_id,
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
$(document).ready(function() {

    <?php if ($id) { ?>
    loadDetail(<?= $id ?>)
    <?php } ?>
});
</script>