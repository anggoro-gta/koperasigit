<style>
/* Card ala gambar */
.bs3-card {
    background: #fff;
    border: 1px solid #e5e5e5;
    border-radius: 6px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
    margin-bottom: 18px;
    overflow: hidden;
}

.bs3-card-header {
    padding: 14px 16px;
    background: #fafafa;
    border-bottom: 1px solid #eee;
}

.bs3-card-title {
    margin: 0;
    font-weight: 600;
    font-size: 22px;
}

.bs3-card-body {
    padding: 14px 16px;
}

/* Quick stats rows */
.bs3-stat-row {
    position: relative;
    padding: 10px 0;
}

.bs3-stat-label {
    font-weight: 600;
    color: #222;
}

/* pill badge kanan */
.bs3-pill {
    float: right;
    padding: 4px 10px;
    border-radius: 10px;
    font-weight: 700;
    font-size: 12px;
    color: #fff;
    line-height: 16px;
}

/* warna pill */
.bs3-pill-blue {
    background: #1e88ff;
}

.bs3-pill-green {
    background: #1aa260;
}

.bs3-pill-cyan {
    background: #00bcd4;
}

/* resource list */
.bs3-resource {
    list-style: none;
    margin: 0;
    padding: 0;
}

.bs3-resource li {
    padding: 10px 0;
}

.bs3-resource li+li {
    border-top: 1px solid #f0f0f0;
}

.bs3-resource a {
    color: #2c3e50;
    text-decoration: none;
}

.bs3-resource a:hover {
    text-decoration: underline;
}

/* ikon kiri */
.bs3-ico {
    display: inline-block;
    width: 26px;
    text-align: center;
    margin-right: 10px;
    font-size: 16px;
    vertical-align: middle;
}

.bs3-ico-blue {
    color: #1e88ff;
}

.bs3-ico-green {
    color: #1aa260;
}

.bs3-ico-orange {
    color: #f39c12;
}

.bs3-ico-cyan {
    color: #00bcd4;
}
</style>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Penarikan</h3>
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
            <div class="x_panel" style="width: 50%">
                <div class="x_title">
                    <ul class="nav navbar-left panel_toolbox">
                        <div class="pull-left">
                            <a href="<?= $act_back ?>" class="btn btn-sm btn-dark"><i
                                    class="glyphicon glyphicon-chevron-left"></i> kembali</a>
                        </div>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="<?= $action; ?>" method="post" id="demo-form2" data-parsley-validate
                        class="form-horizontal form-label-left" autocomplete='off'>
                        <input type="hidden" name="id" value="<?= $id ?>">

                        <div class="form-group required">
                            <label class="control-label">Anggota</label>
                            <select class="form-control" name="fk_anggota_id" id="fk_anggota_id" required>
                                <option value="">.: Pilih :.</option>
                                <?php foreach ($arrUserAnggota as $valanggota) { ?>
                                <option <?= $fk_anggota_id == $valanggota['id'] ? 'selected' : '' ?>
                                    value="<?= $valanggota['id'] ?>">
                                    <?= $valanggota['nama'] . ' (' . $valanggota['nama_skpd'] . ')' ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php
                          $jumlah_akhir = 0;
                          $total_simpanan = 0;
                          $total_tanggungan = 0;
                        ?>
                        <div class="row" id="div_detail" style="display:none;">
                            <div class="col-sm-12">

                                <!-- CARD: Quick Stats -->
                                <div class="bs3-card">
                                    <div class="bs3-card-header">
                                        <h4 class="bs3-card-title text-primary"><i class="fas fa-wallet"></i>
                                            SIMPANAN</h4>
                                    </div>

                                    <div class="bs3-card-body">
                                        <ul class="bs3-resource">
                                            <li class="clearfix">
                                                <span>POKOK</span>
                                                <span class="pull-right text-right" id="simpanan_pokok"
                                                    style="font-size:14px">Rp 0,00</span>
                                            </li>
                                            <li class="clearfix">
                                                <span>WAJIB</span>
                                                <span class="pull-right text-right" id="simpanan_wajib"
                                                    style="font-size:14px">Rp 0,00</span>
                                            </li>
                                            <li class="clearfix">
                                                <span>TERPIMPIN</span>
                                                <span class="pull-right text-right" id="simpanan_tapim"
                                                    style="font-size:14px">Rp 0,00</span>
                                            </li>
                                            <li class="clearfix">
                                                <span>SUKARELA</span>
                                                <span class="pull-right text-right" id="simpanan_sukarela"
                                                    style="font-size:14px">Rp 0,00</span>
                                            </li>
                                            <li class="clearfix">
                                                <strong>TOTAL SIMPANAN</strong>
                                                <strong class="pull-right text-right" id="total_simpanan"
                                                    style="font-size:16px">Rp 0,00</strong>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- CARD: Related Resources -->
                                <div class="bs3-card">
                                    <div class="bs3-card-header">
                                        <h4 class="bs3-card-title text-danger"><i class="fas fa-file-invoice"></i>
                                            TANGGUNGAN
                                        </h4>
                                    </div>
                                    <div class="bs3-card-body">
                                        <div id="sec_uang" style="display:none;">
                                            <span class="badge" style="margin-bottom:10px">PINJAMAN UANG</span>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th class="text-right">Pokok</th>
                                                            <th class="text-right">Bunga</th>
                                                            <th class="text-center">Sisa Angsuran</th>
                                                            <th class="text-right">Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbody_uang"></tbody>
                                                </table>
                                                <hr>
                                            </div>
                                        </div>
                                        <div id="sec_barang" style="display:none;">
                                            <span class="badge" style="margin-bottom:10px">PINJAMAN BARANG</span>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th class="text-right">Pokok</th>
                                                            <th class="text-right">Bunga</th>
                                                            <th class="text-center">Sisa Angsuran</th>
                                                            <th class="text-right">Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbody_barang"></tbody>
                                                </table>
                                                <hr>
                                            </div>
                                        </div>
                                        <div id="sec_palen" style="display:none;">
                                            <span class="badge" style="margin-bottom:10px">PINJAMAN BARANG</span>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th class="text-right">Pokok</th>
                                                            <th class="text-right">Bunga</th>
                                                            <th class="text-center">Sisa Angsuran</th>
                                                            <th class="text-right">Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbody_palen"></tbody>
                                                </table>
                                                <hr>
                                            </div>
                                        </div>

                                        <ul class="bs3-resource">
                                            <li class="clearfix">
                                                <strong>TOTAL TANGGUNGAN</strong>
                                                <strong class="pull-right text-right" id="total_tanggungan"
                                                    style="font-size:16px">Rp 0,00</strong>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="bs3-card">
                                    <div class="bs3-card-body">
                                        <ul class="bs3-resource">
                                            <li class="clearfix">
                                                <span>JUMLAH AKHIR</span>
                                                <strong class="pull-right text-right" id="jumlah_akhir"
                                                    style="font-size:16px">Rp 0,00</strong>
                                            </li>
                                            <li class="clearfix">
                                                <span>PENARIKAN</span>

                                                <span class="pull-right text-right">
                                                    <div class="input-group" style="width:220px;">
                                                        <span class="input-group-addon">Rp</span>
                                                        <input type="text" id="nominal_penarikan_view"
                                                            class="form-control text-right" placeholder="0"
                                                            autocomplete="off" inputmode="numeric">
                                                    </div>

                                                    <!-- nilai mentah untuk dikirim (angka saja) -->
                                                    <input type="hidden" id="nominal_penarikan" name="nominal_penarikan"
                                                        value="<?= (int)round($jumlah_penarikan) ?>">
                                                </span>
                                            </li>
                                            <li class="clearfix">
                                                <span>TANGGAL PENARIKAN</span>
                                                <span class="pull-right text-right">
                                                    <input type="date" id="tanggal_penarikan" name="tanggal_penarikan"
                                                        class="form-control form-control-sm" style="width:170px"
                                                        value="<?= $tgl_penarikan ?>"></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <button id="btn_submit" type="submit" class="btn btn-success"
                                disabled><?= $button ?></button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
function rupiah(n) {
    n = Number(n || 0);
    return 'Rp ' + n.toLocaleString('id-ID', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

function onlyDigits(s) {
    return (s || '').toString().replace(/[^\d]/g, '');
}

function formatRupiahInt(numStr) {
    numStr = onlyDigits(numStr);
    if (numStr === '') return '0';
    numStr = numStr.replace(/^0+(?=\d)/, '');
    return numStr.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

function renderRows(tbodyId, rows) {
    var $tb = $('#' + tbodyId);
    $tb.empty();
    if (!rows || rows.length === 0) {
        $tb.append('<tr><td colspan="5" class="text-center text-muted">Tidak ada data</td></tr>');
        return;
    }
    var no = 1;
    rows.forEach(function(r) {
        $tb.append(
            '<tr>' +
            '<td>' + (no++) + '.</td>' +
            '<td class="text-right">' + rupiah(r.pokok) + '</td>' +
            '<td class="text-right">' + rupiah(r.bunga) + '</td>' +
            '<td class="text-center">' + r.sisa_angsuran + 'x</td>' +
            '<td class="text-right">' + rupiah(r.total) + '</td>' +
            '</tr>'
        );
    });
}

function refreshSubmitState() {
    var anggota = $('#fk_anggota_id').val();
    var nominal = Number($('#nominal_penarikan').val() || 0);
    var tgl = ($('#tanggal_penarikan').val() || '').trim();
    var ok = anggota && nominal > 0 && tgl !== '';
    $('#btn_submit').prop('disabled', !ok);
}

$(function() {
    var $detail = $('#div_detail');
    var $view = $('#nominal_penarikan_view');
    var $raw = $('#nominal_penarikan');
    var isEdit = Number($('input[name="id"]').val() || 0) > 0;

    // init format nominal dari hidden
    $view.val(formatRupiahInt($raw.val()));

    // format input + update hidden raw
    $view.on('input', function() {
        var digits = onlyDigits($(this).val());
        var maks = Number($view.data('maks') || 0);
        var val = Number(digits || 0);
        if (maks > 0 && val > maks) {
            val = maks;
            digits = String(maks);
        }
        $raw.val(val);
        $(this).val(formatRupiahInt(digits));
        refreshSubmitState();
    }).on('focus', function() {
        this.select();
    });

    $('#tanggal_penarikan, #fk_anggota_id').on('change input', refreshSubmitState);

    // load detail saat pilih anggota
    function loadDetail() {
        var anggotaId = $('#fk_anggota_id').val();
        if (!anggotaId) {
            $detail.hide();
            return;
        }

        $.ajax({
            url: "<?= site_url('Penarikan/ajax_detail') ?>",
            type: "POST",
            dataType: "json",
            data: {
                fk_anggota_id: anggotaId
            },
            success: function(res) {
                if (!res.ok) {
                    alert(res.message || 'Gagal mengambil data');
                    $detail.hide();
                    return;
                }

                $detail.show();

                $('#simpanan_pokok').text(rupiah(res.simpanan.pokok));
                $('#simpanan_wajib').text(rupiah(res.simpanan.wajib));
                $('#simpanan_tapim').text(rupiah(res.simpanan.tapim));
                $('#simpanan_sukarela').text(rupiah(res.simpanan.sukarela));
                $('#total_simpanan').text(rupiah(res.total_simpanan));

                if (res.tanggungan.uang && res.tanggungan.uang.length) {
                    $('#sec_uang').show();
                    renderRows('tbody_uang', res.tanggungan.uang);
                } else {
                    $('#sec_uang').hide();
                }

                if (res.tanggungan.barang && res.tanggungan.barang.length) {
                    $('#sec_barang').show();
                    renderRows('tbody_barang', res.tanggungan.barang);
                } else {
                    $('#sec_barang').hide();
                }

                if (res.tanggungan.palen && res.tanggungan.palen.length) {
                    $('#sec_palen').show();
                    renderRows('tbody_palen', res.tanggungan.palen);
                } else {
                    $('#sec_palen').hide();
                }

                $('#total_tanggungan').text(rupiah(res.total_tanggungan));
                $('#jumlah_akhir').text(rupiah(res.jumlah_akhir))
                    .removeClass('text-danger text-success')
                    .addClass(res.jumlah_akhir > 0 ? 'text-success' : 'text-danger');

                // set batas maks
                $view.data('maks', res.jumlah_akhir > 0 ? Math.floor(res.jumlah_akhir) : 0);

                // kalau edit, tetap biarkan input aktif (optional)
                // kalau mau strict: pakai res.can_withdraw
                var can = res.can_withdraw || isEdit;
                $('#nominal_penarikan_view, #tanggal_penarikan').prop('disabled', !can);

                refreshSubmitState();
            },
            error: function() {
                alert('Error AJAX detail');
                $detail.hide();
            }
        });
    }

    $('#fk_anggota_id').on('change', function() {
        // reset nominal saat ganti anggota di mode create
        if (!isEdit) {
            $raw.val(0);
            $view.val('0');
            $('#btn_submit').prop('disabled', true);
        }
        loadDetail();
    });

    // AUTO LOAD saat edit (anggota sudah terpilih)
    if ($('#fk_anggota_id').val()) {
        loadDetail();
        $detail.show();
    }

    // submit via ajax (CEGAH submit normal)
    $('#demo-form2').on('submit', function(e) {
        e.preventDefault();
        refreshSubmitState();
        if ($('#btn_submit').prop('disabled')) return;

        var $btn = $('#btn_submit');
        $btn.prop('disabled', true).text('Menyimpan...');

        $.ajax({
            url: "<?= site_url('Penarikan/ajax_save') ?>",
            type: "POST",
            dataType: "json",
            data: {
                id: $('input[name="id"]').val(),
                fk_anggota_id: $('#fk_anggota_id').val(),
                tanggal_penarikan: $('#tanggal_penarikan').val(),
                nominal_penarikan: $('#nominal_penarikan').val()
            },
            success: function(res) {
                if (!res.ok) {
                    alert(res.message || 'Gagal menyimpan');
                    $btn.prop('disabled', false).text('<?= $button ?>');
                    refreshSubmitState();
                    return;
                }
                window.location.href = res.redirect_url || "<?= site_url('Penarikan') ?>";
            },
            error: function() {
                alert('Error AJAX simpan');
                $btn.prop('disabled', false).text('<?= $button ?>');
                refreshSubmitState();
            }
        });
    });

    refreshSubmitState();
});
</script>