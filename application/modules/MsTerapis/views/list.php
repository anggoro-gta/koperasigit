
<div class="page-title">
    <div class="title_left">
        <h3>Terapis</h3>
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
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Error!</strong> <?php echo $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>
        <div class="x_panel">
            <div class="x_title">
                <h2>Pencarian</h2>
                <div class="clearfix"></div>
            </div>
            <form class="form-horizontal form-label-left"  autocomplete="off">
                <div class="form-group">
                    <?php if($this->session->fk_level_id==1){ ?>
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">Cabang</label>
                        <div class="col-md-6 col-sm-4 col-xs-12">
                            <div class="input-group">
                                <select class="form-control" name="fk_cabang_id" id="fk_cabang_id">
                                    <option value="">.: Pilih :.</option>
                                    <?php foreach ($arrcabang as $val) { ?>
                                        <option value="<?=$val['id']?>"><?=$val['nama_cabang']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    <?php } else{ ?>
                        <input type="hidden" id="fk_cabang_id" value="<?=$this->session->fk_cabang_id?>">
                    <?php } ?>
                </div>
                <div class="form-group"> 
                    <div class="col-md-12">
                        <div class="col-md-2 col-sm-2 col-xs-12"></div>
                        <a class="btn btn-sm btn-success" id="tampil"><i class="glyphicon glyphicon-search"></i> Tampilkan</a>
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

$("#tampil").click(function(){
    data();
});
function data(){   
    fk_cabang_id = $("#fk_cabang_id").val();
    
    $.ajax({
        type:'post',
        url: "<?php echo base_url()?>MsTerapis/getListDetail",
        data:{fk_cabang_id},
        beforeSend  : function(){
            $("body").css("cursor", "progress");      
        },
        success: function(data){
            $("body").css("cursor", "default");
            $("#tampilData").html(data);
        }
    });
};
</script>