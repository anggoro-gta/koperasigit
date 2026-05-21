<style>
.table-responsive {
    overflow-x: auto;
    position: relative;
}

.table-bku {
    min-width: 1500px;
    border-collapse: separate;
    border-spacing: 0;
}

/* Freeze kolom pertama pada body */
.table-bku tbody tr>td:first-child,
.table-bku tbody tr>th:first-child {
    position: sticky;
    left: 0;
    z-index: 5;
    background: #f9f9f9;
    font-weight: 700;
    min-width: 130px;
    box-shadow: 2px 0 4px rgba(0, 0, 0, 0.08);
}

/* Freeze header BULAN */
.table-bku thead tr:first-child>th:first-child {
    position: sticky;
    left: 0;
    z-index: 10;
    background: #ffffff;
    min-width: 130px;
    box-shadow: 2px 0 4px rgba(0, 0, 0, 0.08);
}

/* Supaya warna tetap rapi saat hover/striped */
.table-bku tbody tr:nth-child(odd)>td:first-child,
.table-bku tbody tr:nth-child(odd)>th:first-child {
    background: #f9f9f9;
}

.table-bku tbody tr:nth-child(even)>td:first-child,
.table-bku tbody tr:nth-child(even)>th:first-child {
    background: #ffffff;
}
</style>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>BKU Pengeluaran</h3>
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
            <div class="x_panel">
                <div class="x_title">
                    <ul class="nav navbar-left panel_toolbox">
                        <div class="pull-left">
                            <a onclick="window.history.back()" class="btn btn-sm btn-warning"><i
                                    class="glyphicon glyphicon-chevron-left"></i> kembali</a>
                        </div>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <form action="<?= $action; ?>" method="post" id="demo-form2" data-parsley-validate
                        class="form-horizontal form-label-left">
                        <div class="form-group required">
                            <label class="control-label col-md-5 col-sm-3 col-xs-12" for="last-name">Periode</label>
                            <div class="col-md-2 col-sm-6 col-xs-12">
                                <input type="month" name="periode" id="periode" required
                                    class="form-control col-md-7 col-xs-12" value="<?= $periode ?>"
                                    <?= $periode ? 'disabled' : ''?>>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-bku" style="font-size: 9pt">
                                <thead>
                                    <tr>
                                        <th rowspan="2" class="text-center">BULAN</th>
                                        <th colspan="4" class="text-center">MACAM - MACAM SIMPANAN</th>
                                        <th rowspan="2" class="text-center">DANA SOSIAL</th>
                                        <th rowspan="2" class="text-center">BIAYA</th>
                                        <th rowspan="2" class="text-center">PENGELUARAN KREDIT</th>
                                        <th rowspan="2" class="text-center">BARANG</th>
                                        <th rowspan="2" class="text-center">PAJAK</th>
                                        <th rowspan="2" class="text-center">DANA PENDIDIKAN</th>
                                        <th rowspan="2" class="text-center">SHU</th>
                                        <th rowspan="2" class="text-center">INVENTARIS_KANTOR</th>
                                        <th rowspan="2" class="text-center">CADANGAN PEMB. USAHA</th>
                                        <th rowspan="2" class="text-center">JUMLAH</th>
                                        <th rowspan="2" class="text-center">AKSI</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">POKOK</th>
                                        <th class="text-center">WAJIB</th>
                                        <th class="text-center">TAPIM</th>
                                        <th class="text-center">S. RELA</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-pengeluaran">
                                    <tr>
                                        <td colspan="16" class="text-center text-muted">
                                            Silakan pilih periode terlebih dahulu.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="modalFormPengeluaran" tabindex="-1" role="dialog"
    aria-labelledby="modalFormPengeluaranLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form id="formBkuPengeluaran" method="post" action="<?= base_url('BKU/Pengeluaran/save_modal') ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                    <h4 class="modal-title" id="modalFormPengeluaranLabel">
                        Input BKU Pengeluaran
                    </h4>
                </div>

                <div class="modal-body" id="modalFormPengeluaranBody">
                    <div class="text-center">
                        Memuat form...
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit" class="btn btn-success">
                        Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
<script>
$(document).ready(function() {

    $('#periode').on('change', function() {
        var periode = $(this).val();

        if (periode == '') {
            $('#judul-periode').html('SILAKAN PILIH PERIODE');

            $('#tbody-pengeluaran').html(`
                <tr>
                    <td colspan="15" class="text-center text-muted">
                        Silakan pilih periode terlebih dahulu.
                    </td>
                </tr>
            `);

            return;
        }

        $.ajax({
            url: "<?= base_url('BKU/Pengeluaran/get_form_periode') ?>",
            type: "POST",
            dataType: "json",
            data: {
                periode: periode
            },
            beforeSend: function() {
                $('#judul-periode').html('MEMUAT DATA...');

                $('#tbody-pengeluaran').html(`
                    <tr>
                        <td colspan="15" class="text-center">
                            <i class="glyphicon glyphicon-refresh"></i> Memuat data...
                        </td>
                    </tr>
                `);
            },
            success: function(res) {
                if (res.status == 'success') {
                    $('#tbody-pengeluaran').html(res.html);
                } else {
                    $('#tbody-pengeluaran').html(`
                        <tr>
                            <td colspan="15" class="text-center text-danger">
                                ${res.message}
                            </td>
                        </tr>
                    `);
                }
            },
            error: function() {
                $('#tbody-pengeluaran').html(`
                    <tr>
                        <td colspan="15" class="text-center text-danger">
                            Gagal mengambil data periode.
                        </td>
                    </tr>
                `);
            }
        });
    });

    // otomatis load detail ketika masuk dari tombol View
    if ($('#periode').val() !== '') {
        $('#periode').trigger('change');
    }

});

function formModal(tahun, bulan, idKategori) {
    $('#modalFormPengeluaran').modal('show');

    $('#modalFormPengeluaranBody').html(`
        <div class="text-center">
            <i class="glyphicon glyphicon-refresh"></i> Memuat form...
        </div>
    `);

    $.ajax({
        url: "<?= base_url('BKU/Pengeluaran/form_modal') ?>",
        type: "POST",
        data: {
            tahun: tahun,
            bulan: bulan,
            id_kategori: idKategori
        },
        success: function(html) {
            $('#modalFormPengeluaranBody').html(html);
        },
        error: function() {
            $('#modalFormPengeluaranBody').html(`
                <div class="alert alert-danger">
                    Gagal memuat form pengeluaran.
                </div>
            `);
        }
    });
}

$(document).on('input', '.input-rupiah', function() {
    let value = $(this).val();

    value = value.replace(/[^0-9,]/g, '');

    let parts = value.split(',');
    let angka = parts[0].replace(/\D/g, '');
    let desimal = parts[1] !== undefined ? ',' + parts[1].substring(0, 2) : '';

    angka = angka.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

    $(this).val(angka + desimal);
});

$(document).on('submit', '#formBkuPengeluaran', function(e) {
    e.preventDefault();

    $.ajax({
        url: $('#formBkuPengeluaran').attr('action'),
        type: 'POST',
        data: $('#formBkuPengeluaran').serialize(),
        dataType: 'json',
        beforeSend: function() {
            $('#formBkuPengeluaran button[type="submit"]').prop('disabled', true).text(
                'Menyimpan...');
        },
        success: function(res) {
            $('#formBkuPengeluaran button[type="submit"]').prop('disabled', false).text(
                'Simpan');

            if (res.status == 'success') {
                $('#modalFormPengeluaran').modal('hide');

                // reload tabel periode yang sedang aktif
                $('#periode').trigger('change');
            } else {
                alert(res.message);
            }
        },
        error: function() {
            $('#formBkuPengeluaran button[type="submit"]').prop('disabled', false).text(
                'Simpan');
            alert('Terjadi kesalahan saat menyimpan data.');
        }
    });
});
</script>