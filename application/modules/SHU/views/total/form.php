<style>
.mb-3 {
    margin-bottom: 1rem
}
</style>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Form SHU - Total</h3>
        </div>

        <div class="title_right">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group"></div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">

            <div class="x_panel">
                <div class="x_title">
                    <ul class="nav navbar-left panel_toolbox">
                        <div class="pull-left">
                            <a href="<?= base_url('SHU/Total') ?>" class="btn btn-sm btn-warning"><i
                                    class="glyphicon glyphicon-chevron-left"></i> kembali</a>
                        </div>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content collapse show" id="panel-content-4">
                    <br>
                    <form action="<?= $action ?>" method="POST" class="form-horizontal form-label-left">
                        <input type="hidden" id="old_id" value="<?= $id; ?>">
                        <input type="hidden" name="id" id="id" value="<?= $id; ?>">
                        <div class="mb-3 row">
                            <label class="col-form-label col-md-3 col-sm-3">Tahun <span
                                    class="required text-danger">*</span></label>
                            <div class="col-md-9 col-sm-9">
                                <input type="number" name="tahun" id="tahun" value="<?= $tahun ?>"
                                    class="form-control tahun" required placeholder="Input tahun">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-form-label col-md-3 col-sm-3">Nominal <span
                                    class="required text-danger">*</span></label>
                            <div class="col-md-9 col-sm-9">
                                <input type="text" name="nominal" id="nominal"
                                    value="<?= !empty($nominal) ? number_format($nominal, 0, '.', ',') : '' ?>"
                                    class="form-control" required placeholder="Input nominal">
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="mb-3">
                            <div class="col-md-9 col-sm-9 offset-md-3">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                                    <button type="reset" class="btn btn-primary reset">Batal</button>
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
$('#tahun').on('keyup change', function() {
    loadDetail($(this).val());
});

$('.reset').on('click', function() {
    var old_id = $('#old_id').val()
    $('#id').val(old_id)
});

function formatRupiah(value) {
    let s = (value + '').replace(/[^\d]/g, '');
    if (!s) return '';
    return s.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

function unformatRupiah(value) {
    return (value + '').replace(/[^\d]/g, '');
}

$('#nominal').on('input', function() {
    $(this).val(formatRupiah($(this).val()));
});

function loadDetail(tahun) {
    $('#nominal').attr('readonly', true);
    $('#nominal').val('Loading...');

    $.ajax({
        url: "<?= site_url('SHU/Total/ajax_detail') ?>",
        type: "POST",
        dataType: "json",
        data: {
            tahun: tahun
        },
        success: function(res) {
            $('#nominal').attr('readonly', false);

            $('#id').val(res.result.id);
            $('#nominal').val(formatRupiah(res.result.nominal)); // <-- format di sini
        },
        error: function() {
            alert('Error AJAX load data');
        }
    });
}
</script>