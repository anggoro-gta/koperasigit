<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>History Mutasi</h3>
        </div>

        <div class="title_right">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group"></div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <form action="<?= $action; ?>" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" autocomplete='off'>
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
                                <a href="<?= $act_back ?>" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-chevron-left"></i> kembali</a>
                            </div>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <input type="hidden" name="id" value="<?= $id ?>">
            </div>
            <div id="tampilData">

            </div>
        </form>
    </div>
</div>
</div>
<script>
    function loadDetail(id) {
        if (id) {
            url = "<?php echo base_url() ?>MscbAnggotaMutasi/getData/" + id;
        } else {
            url = "<?php echo base_url() ?>MscbAnggotaMutasi/getData";
        }
        let datatest = "ini data kiriman"
        $.ajax({
            type: 'post',
            url: url,
            data: {
                datatest,
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