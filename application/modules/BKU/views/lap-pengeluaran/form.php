<style>
.row-migrasi {
    display: flex;
    align-items: center;
}

.row-migrasi>div {
    padding-left: 5px;
    padding-right: 5px;
}

.migrasi-icon {
    height: 34px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #73879C;
}

.migrasi-icon i {
    font-size: 18px;
}

@media (max-width: 480px) {
    .row-migrasi .form-control {
        font-size: 12px;
        padding-left: 6px;
        padding-right: 6px;
    }

    .migrasi-icon i {
        font-size: 16px;
    }
}
</style>
<style>
.table-responsive {
    position: relative;
    overflow-x: visible;
}

.table-bku {
    min-width: 1800px;
    border-collapse: separate;
    border-spacing: 0;
}

/* Lebar kolom freeze */
.table-bku .freeze-no {
    min-width: 60px;
    width: 60px;
}

.table-bku .freeze-bulan {
    min-width: 110px;
    width: 110px;
}

.table-bku .freeze-tahun {
    min-width: 80px;
    width: 80px;
}

/* Freeze kolom No */
.table-bku th.freeze-no,
.table-bku td.freeze-no {
    position: sticky;
    left: 0;
    z-index: 8;
    background: #fff;
    box-shadow: 2px 0 3px rgba(0, 0, 0, 0.08);
}

/* Freeze kolom Bulan */
.table-bku th.freeze-bulan,
.table-bku td.freeze-bulan {
    position: sticky;
    left: 60px;
    z-index: 8;
    background: #fff;
    box-shadow: 2px 0 3px rgba(0, 0, 0, 0.08);
}

/* Freeze kolom Tahun */
.table-bku th.freeze-tahun,
.table-bku td.freeze-tahun {
    position: sticky;
    left: 170px;
    z-index: 8;
    background: #fff;
    box-shadow: 2px 0 3px rgba(0, 0, 0, 0.08);
}

/* Header harus lebih tinggi z-index */
.table-bku thead th.freeze-no,
.table-bku thead th.freeze-bulan,
.table-bku thead th.freeze-tahun {
    z-index: 20;
    background: #fff;
}

/* Supaya warna striped tetap rapi */
.table-bku tbody tr:nth-child(odd) td.freeze-no,
.table-bku tbody tr:nth-child(odd) td.freeze-bulan,
.table-bku tbody tr:nth-child(odd) td.freeze-tahun {
    background: #f9f9f9;
}

.table-bku tbody tr:nth-child(even) td.freeze-no,
.table-bku tbody tr:nth-child(even) td.freeze-bulan,
.table-bku tbody tr:nth-child(even) td.freeze-tahun {
    background: #fff;
}

/* Lebar kolom Action */
.table-bku .freeze-action {
    min-width: 90px;
    width: 90px;
}

/* Freeze kolom Action di kanan */
.table-bku th.freeze-action,
.table-bku td.freeze-action {
    position: sticky;
    right: 0;
    z-index: 9;
    background: #fff;
    box-shadow: -2px 0 3px rgba(0, 0, 0, 0.08);
    white-space: nowrap;
}

/* Header action lebih tinggi */
.table-bku thead th.freeze-action {
    z-index: 21;
    background: #fff;
}

/* Supaya warna striped tetap rapi */
.table-bku tbody tr:nth-child(odd) td.freeze-action {
    background: #f9f9f9;
}

.table-bku tbody tr:nth-child(even) td.freeze-action {
    background: #fff;
}

.table-bku tfoot th {
    background: #eef3f7;
    border-top: 2px solid #d8dee6;
    color: #2A3F54;
    font-weight: bold;
    vertical-align: middle;
}

.table-bku tfoot th.freeze-no,
.table-bku tfoot th.freeze-bulan,
.table-bku tfoot th.freeze-tahun {
    z-index: 22;
    background: #eef3f7;
}

.table-bku tfoot th.freeze-action {
    z-index: 23;
    background: #eef3f7;
}

.dataTables_wrapper {
    width: 100%;
}

.dataTables_scroll {
    width: 100%;
}

.dataTables_scrollBody {
    overflow-x: auto !important;
    overflow-y: hidden !important;
}
</style>
<div class="page-title">
    <div class="title_left">
        <h3>Laporan Pengeluaran</h3>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_content">
                <form action="<?= $action; ?>" method="post" id="demo-form2" data-parsley-validate
                    class="form-horizontal form-label-left">
                    <div class="form-group required">
                        <label class="control-label col-md-4 col-sm-3 col-xs-12" for="last-name">Periode
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <input type="month" name="periode" required class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <!-- Nilai Tunai -->
                    <div class="form-group required">
                        <label class="control-label col-md-4 col-sm-3 col-xs-12" for="nilai_tunai">
                            Nilai Tunai
                        </label>

                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <input type="text" id="nilai_tunai" name="nilai_tunai" class="form-control input-rupiah"
                                placeholder="0" inputmode="numeric" autocomplete="off" required>
                        </div>
                    </div>

                    <!-- Nilai Bank -->
                    <div class="form-group required">
                        <label class="control-label col-md-4 col-sm-3 col-xs-12" for="nilai_bank">
                            Nilai Bank
                        </label>

                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <input type="text" id="nilai_bank" name="nilai_bank" class="form-control input-rupiah"
                                placeholder="0" inputmode="numeric" autocomplete="off" required>
                        </div>
                    </div>

                    <div class="form-group required">
                        <label class="control-label col-md-4 col-sm-3 col-xs-12" for="last-name">Nama Ketua I
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <input type="text" name="nama_ketua_1" required class="form-control col-md-7 col-xs-12"
                                value="">
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="control-label col-md-4 col-sm-3 col-xs-12" for="last-name">Nama Bendahara I
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <input type="text" name="nama_bendahara_1" required class="form-control col-md-7 col-xs-12"
                                value="">
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="control-label col-md-4 col-sm-3 col-xs-12" for="last-name">Nama Manager
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <input type="text" name="nama_manager" required class="form-control col-md-7 col-xs-12"
                                value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">
                            <button type="submit" name="tipe" value="pdf" class="btn btn-danger">
                                <i class="glyphicon glyphicon-file"></i>
                                Cetak PDF
                            </button>

                            <button type="submit" name="tipe" value="excel" class="btn btn-success">
                                <i class="glyphicon glyphicon-download"></i>
                                Download Excel
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
    const rupiahInputs = document.querySelectorAll('.input-rupiah');

    /*
    |--------------------------------------------------------------------------
    | Format Angka dengan Pemisah Ribuan
    |--------------------------------------------------------------------------
    */

    function formatRupiah(value) {
        const number = String(value).replace(/\D/g, '');

        if (number === '') {
            return '';
        }

        return new Intl.NumberFormat('id-ID', {
            maximumFractionDigits: 0,
        }).format(Number(number));
    }

    /*
    |--------------------------------------------------------------------------
    | Format Otomatis Saat Mengetik
    |--------------------------------------------------------------------------
    */

    rupiahInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            this.value = formatRupiah(this.value);
        });

        if (input.value !== '') {
            input.value = formatRupiah(input.value);
        }
    });

    /*
    |--------------------------------------------------------------------------
    | Hapus Format Sebelum Form Dikirim
    |--------------------------------------------------------------------------
    */

    const form = document.getElementById('demo-form2');

    if (form) {
        form.addEventListener('submit', function() {
            rupiahInputs.forEach(function(input) {
                input.value = input.value.replace(/\D/g, '');
            });
        });
    }
});
</script>