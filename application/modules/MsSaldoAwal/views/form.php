<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Saldo Awal Tahun</h3>
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
                                    class="glyphicon glyphicon-chevron-left"></i> kembali</a>
                        </div>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <form action="<?= $action; ?>" method="post" id="demo-form2" data-parsley-validate
                        class="form-horizontal form-label-left" autocomplete='off'>
                        <div class="form-group required">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Tahun</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="number" id="tahun" name="tahun" required
                                    class="form-control col-md-7 col-xs-12" value="<?= $tahun ?>"
                                    <?= $button=='Update' ? 'readonly' : '' ?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Anggaran</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="input-group">
                                    <input type="text" id="anggaran" name="anggaran" required class="form-control"
                                        value="<?= $anggaran ? number_format($anggaran, 2, ',', '.') : '' ?>">
                                    <span class="input-group-btn">
                                        <button type="button" id="btn-tarik-anggaran" class="btn btn-info">
                                            <i class="glyphicon glyphicon-download-alt"></i> Tarik
                                        </button>
                                    </span>
                                </div>
                                <div id="tarik-anggaran-info" style="display:none; margin-top:10px;"></div>
                            </div>
                        </div>

                        <input type="hidden" id="saldo_awal_id" name="id" value="<?= $id ?>">
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
document.addEventListener('DOMContentLoaded', function() {
    var tahunInput = document.getElementById('tahun');
    var anggaranInput = document.getElementById('anggaran');
    var tarikButton = document.getElementById('btn-tarik-anggaran');
    var tarikInfo = document.getElementById('tarik-anggaran-info');
    var saldoAwalIdInput = document.getElementById('saldo_awal_id');
    if (!anggaranInput) return;

    function formatAnggaran(value) {
        value = String(value || '').replace(/[^0-9,]/g, '');

        if (value === '') return '';

        // cek apakah user baru saja mengetik koma di akhir
        var endsWithComma = value.endsWith(',');

        var parts = value.split(',');

        // bagian angka utama
        var integerPart = parts[0].replace(/\D/g, '');
        integerPart = integerPart.replace(/^0+(?=\d)/, '');

        if (integerPart === '') {
            integerPart = '0';
        }

        integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

        // kalau ada koma/desimal
        if (parts.length > 1) {
            var decimalPart = parts[1].replace(/\D/g, '').substring(0, 2);

            // supaya koma tetap muncul walaupun belum ada angka setelahnya
            if (endsWithComma) {
                return integerPart + ',';
            }

            return integerPart + ',' + decimalPart;
        }

        return integerPart;
    }

    function normalizeAnggaran(value) {
        return String(value || '').replace(/\./g, '').replace(/,/g, '.');
    }

    anggaranInput.addEventListener('input', function(e) {
        e.target.value = formatAnggaran(e.target.value);
    });

    anggaranInput.value = formatAnggaran(anggaranInput.value);

    function setTarikInfo(message, status) {
        if (!tarikInfo) return;

        if (!message) {
            tarikInfo.style.display = 'none';
            tarikInfo.className = '';
            tarikInfo.textContent = '';
            return;
        }

        tarikInfo.style.display = 'block';
        tarikInfo.className = 'alert alert-' + (status === 'success' ? 'success' : (status === 'error' ?
            'danger' : 'warning'));
        tarikInfo.textContent = message || '';
    }

    if (tarikButton) {
        tarikButton.addEventListener('click', function() {
            var tahun = tahunInput ? tahunInput.value.trim() : '';

            if (!tahun) {
                setTarikInfo('Tahun wajib diisi.', 'warning');
                if (tahunInput) tahunInput.focus();
                return;
            }

            if (!/^\d{4}$/.test(tahun)) {
                setTarikInfo('Tahun wajib diisi dengan format 4 digit.', 'warning');
                if (tahunInput) tahunInput.focus();
                return;
            }

            var buttonHtml = tarikButton.innerHTML;
            tarikButton.disabled = true;
            tarikButton.innerHTML = '<i class="glyphicon glyphicon-refresh"></i> Menarik...';
            setTarikInfo('', '');

            $.ajax({
                url: '<?= base_url('MsSaldoAwal/tarikAnggaran') ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    tahun: tahun,
                    id: saldoAwalIdInput ? saldoAwalIdInput.value : ''
                }
            }).done(function(response) {
                if (response.status === 'success') {
                    anggaranInput.value = formatAnggaran(response.anggaran_format || response
                        .anggaran);
                    setTarikInfo(response.message, 'success');
                    return;
                }

                if (response.reset_anggaran) {
                    anggaranInput.value = '';
                }

                setTarikInfo(response.message || 'Anggaran tidak berhasil ditarik.', 'warning');
            }).fail(function() {
                setTarikInfo('Gagal menarik anggaran. Silahkan coba lagi.', 'error');
            }).always(function() {
                tarikButton.disabled = false;
                tarikButton.innerHTML = buttonHtml;
            });
        });
    }

    // var form = anggaranInput.closest('form');
    // if (form) {
    //     form.addEventListener('submit', function() {
    //         anggaranInput.value = normalizeAnggaran(anggaranInput.value);
    //     });
    // }
});
</script>
