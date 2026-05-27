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
        <h3>BKU Penerimaan</h3>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <strong>Sukses!</strong> <?php echo $this->session->flashdata('success') ?>
        </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> <?php echo $this->session->flashdata('error') ?>
        </div>
        <?php endif; ?>
        <?php
            if(count($list_tahun)>0) :
        ?>
        <div class="x_panel">
            <div class="x_title">
                <span><i class="glyphicon glyphicon-filter"></i> Filter</span>
                <div class="clearfix"></div>
            </div>

            <select name="tahun" id="tahun" class="form-control no-select2" style="width: 180px;" required>
                <option value="">Semua Tahun</option>
                <?php foreach ($list_tahun as $th): ?>
                <option value="<?= $th->tahun ?>"><?= $th->tahun ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php
            endif;    
        ?>

        <div class="x_panel">
            <div class="x_title">
                <h2>List</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <div class="pull-right">
                        <a href="<?= $act_add?>" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-plus"></i>
                            Tambah</a>
                    </div>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br />
                <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-bku" id="example2"
                            style="width: 100%; font-size: 9pt">
                            <thead>
                                <tr>
                                    <th rowspan="2" width="5%" class="freeze-no text-center">No</th>

                                    <th rowspan="2" class="text-center freeze-bulan">
                                        BULAN
                                    </th>

                                    <th rowspan="2" class="text-center freeze-tahun">
                                        TAHUN
                                    </th>
                                    <th colspan="2" class="text-center">ANGSURAN PIUTANG</th>
                                    <th colspan="4" class="text-center">MACAM - MACAM SIMPANAN</th>
                                    <th rowspan="2" class="text-center">ANGSURAN BARANG</th>
                                    <th rowspan="2" class="text-center">PENJUALAN TUNAI</th>
                                    <th rowspan="2" class="text-center">BANK</th>
                                    <th rowspan="2" class="text-center">FOTO COPY</th>
                                    <th rowspan="2" class="text-center">BARANG TITIPAN & KONSINYASI</th>
                                    <th colspan="2" class="text-center">JUMLAH</th>
                                    <th rowspan="2" class="text-center freeze-action">AKSI</th>
                                </tr>
                                <tr>
                                    <th class="text-center">POKOK</th>
                                    <th class="text-center">BUNGA</th>
                                    <th class="text-center">POKOK</th>
                                    <th class="text-center">WAJIB</th>
                                    <th class="text-center">TAPIM</th>
                                    <th class="text-center">S. RELA</th>
                                    <th class="text-center">PENERIMAAN</th>
                                    <th class="text-center">SALDO</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    var t = $("#example2").DataTable({
        scrollX: true,
        autoWidth: false,
        initComplete: function() {
            var api = this.api();
            $('#mytable_filter input')
                .off('.DT')
                .on('keyup.DT', function(e) {
                    if (e.keyCode == 13) {
                        api.search(this.value).draw();
                    }
                });
        },
        'oLanguage': {
            "sProcessing": "Sedang memproses...",
            "sLengthMenu": "Tampilkan _MENU_ entri",
            "sZeroRecords": "Tidak ditemukan data yang sesuai",
            "sInfo": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
            "sInfoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
            "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
            "sInfoPostFix": "",
            "sSearch": "Cari:",
            "sUrl": "",
            "oPaginate": {
                "sFirst": "<<",
                "sPrevious": "<",
                "sNext": ">",
                "sLast": ">>"
            }
        },
        processing: true,
        serverSide: true,
        "pageLength": 12,
        ajax: {
            "url": "<?= base_url()?>BKU/Penerimaan/getDatatables",
            "type": "POST",
            data: function(d) {
                d.tahun = $('#tahun').val();
            }
        },
        columns: [{
                data: 'no',
                orderable: false,
                className: 'text-center freeze-no'
            },
            {
                data: 'bulan',
                orderable: false,
                className: 'text-center freeze-bulan'
            },
            {
                data: 'tahun',
                orderable: false,
                className: 'text-center freeze-tahun'
            },
            {
                data: 'angsuran_pokok',
                orderable: false,
                className: 'text-right'
            },
            {
                data: 'angsuran_bunga',
                orderable: false,
                className: 'text-right'
            },
            {
                data: 'simpanan_pokok',
                orderable: false,
                className: 'text-right'
            },
            {
                data: 'simpanan_wajib',
                orderable: false,
                className: 'text-right'
            },
            {
                data: 'simpanan_tapim',
                orderable: false,
                className: 'text-right'
            },
            {
                data: 'simpanan_sukarela',
                orderable: false,
                className: 'text-right'
            },
            {
                data: 'angsuran_barang',
                orderable: false,
                className: 'text-right'
            },
            {
                data: 'penjualan_tunai',
                orderable: false,
                className: 'text-right'
            },
            {
                data: 'bank',
                orderable: false,
                className: 'text-right'
            },
            {
                data: 'foto_copy',
                orderable: false,
                className: 'text-right'
            },
            {
                data: 'barang_titipan',
                orderable: false,
                className: 'text-right'
            },
            {
                data: 'jumlah_penerimaan',
                orderable: false,
                className: 'text-right'
            },
            {
                data: 'saldo',
                orderable: false,
                className: 'text-right'
            },
            {
                data: 'action',
                orderable: false,
                searchable: false,
                className: 'text-center freeze-action'
            }
        ],
        order: [
            [0, 'asc']
        ],
        rowCallback: function(row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            var index = page * length + (iDisplayIndex + 1);
            $('td:eq(0)', row).html(index);
        }
    });

    $('#tahun').on('change', function() {
        t.ajax.reload();
    });
});
</script>