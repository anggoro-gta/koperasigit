<div class="page-title">
    <div class="title_left">
        <h3>SHU - per OPD</h3>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
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
                <h2>Pencarian</h2>
                <div class="clearfix"></div>
            </div>
            <form class="form-horizontal form-label-left" autocomplete="off">
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-12">SKPD</label>
                    <div class="col-md-6 col-sm-4 col-xs-12">
                        <div class="input-group">
                            <select class="form-control" name="fk_id_skpd" id="fk_id_skpd">
                                <option value="">.: Pilih :.</option>
                                <?php foreach ($arrSkpd as $val) { ?>
                                <option value="<?= $val['id'] ?>"><?= $val['nama_skpd'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- <div class="form-group required">
                    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">Tgl Kunjungan</label>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="input-group">
                            <input type="text" name="tgl_dari" id="tgl_dari" required class="form-control col-md-2 col-xs-10 tanggal text-center">
                            <span class="input-group-addon"><b>s/d</b></span>
                            <input type="text" name="tgl_sampai" id="tgl_sampai" required class="form-control col-md-2 col-xs-10 tanggal text-center">
                        </div>
                    </div>
                </div> -->
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="col-md-2 col-sm-2 col-xs-12"></div>
                        <a class="btn btn-sm btn-success" id="tampil"><i class="glyphicon glyphicon-search"></i>
                            Tampilkan</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="tampilData"></div>

<script type="text/javascript">
$(document).ready(function() {
    data();
});

$("#tampil").click(function() {
    data();
});

function data() {
    skpd = $("#fk_id_skpd").val();
    // tgl_dari = $("#tgl_dari").val();
    // tgl_sampai = $("#tgl_sampai").val();

    $.ajax({
        type: 'post',
        url: "<?php echo base_url() ?>SHU/Opd/getListDetail",
        data: {
            skpd,
            // tgl_dari,
            // tgl_sampai
        },
        beforeSend: function() {
            $("body").css("cursor", "progress");
        },
        success: function(data) {
            $("body").css("cursor", "default");
            $("#tampilData").html(data);
        }
    });
};
</script>