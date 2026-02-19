<div class="page-title">
    <div class="title_left">
        <h3>SHU - Total</h3>
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
    $.ajax({
        type: 'post',
        url: "<?php echo base_url() ?>SHU/Total/getListDetail",
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