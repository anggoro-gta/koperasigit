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
<div class="page-title">
    <div class="title_left">
        <h3>Kategori Penerimaan</h3>
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

        <div class="x_panel">
            <div class="x_title">
                <span><i class="glyphicon glyphicon-filter"></i> Filter</span>
                <div class="clearfix"></div>
            </div>

            <select name="tahun" id="tahun" class="form-control no-select2" style="width: 180px;" required>
                <option value="">Semua Tahun</option>
                <?php foreach ($list_tahun_migrasi as $th): ?>
                <option value="<?= $th->tahun ?>"><?= $th->tahun ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="x_panel">
            <div class="x_title">
                <h2>List</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <div class="pull-right">
                        <a href="<?= $act_add?>" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-plus"></i>
                            Tambah</a>
                        <button type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                            data-target="#modalMigrasi">
                            <i class="glyphicon glyphicon-refresh"></i> Migrasi
                        </button>
                    </div>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br />
                <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                    <div class="form-group">
                        <table class="table table-bordered table-striped" id="example2" style="width: 100%">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th class="text-center">
                                        Nama Kategori Penerimaan
                                    </th>
                                    <th class="text-center">
                                        Tahun
                                    </th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalMigrasi" tabindex="-1" role="dialog" aria-labelledby="modalMigrasiLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form id="formMigrasi" method="post" action="<?= base_url('MsKategori/Penerimaan/migrasi_action') ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="modalMigrasiLabel">
                        Migrasi Kategori Penerimaan
                    </h4>
                </div>

                <div class="modal-body">

                    <div id="alertMigrasi"></div>
                    <div class="row row-migrasi">
                        <div class="col-xs-5 col-sm-5 col-md-5">
                            <select name="tahun_asal" id="tahun_asal" class="form-control no-select2" required>
                                <option value="">Pilih Tahun Referensi</option>
                                <?php foreach ($list_tahun_migrasi as $th): ?>
                                <option value="<?= $th->tahun ?>"><?= $th->tahun ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-xs-2 col-sm-2 col-md-2 text-center migrasi-icon">
                            <i class="glyphicon glyphicon-transfer"></i>
                        </div>

                        <div class="col-xs-5 col-sm-5 col-md-5">
                            <input type="number" name="tahun_tujuan" id="tahun_tujuan" class="form-control"
                                placeholder="Tahun Tujuan, contoh : <?= date('Y') ?>" required>
                        </div>
                    </div>
                    <hr>
                    <p class="text-danger">
                        NB : Data kategori penerimaan dari tahun referensi akan disalin ke tahun tujuan.
                        Jika tahun tujuan sudah memiliki data, proses migrasi tidak akan dijalankan.
                    </p>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-warning">
                        Proses Migrasi
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    var t = $("#example2").DataTable({
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
        "pageLength": 100,
        ajax: {
            "url": "<?= base_url()?>MsKategori/Penerimaan/getDatatables",
            "type": "POST",
            data: function(d) {
                d.tahun = $('#tahun').val();
            }
        },
        columns: [{
                "data": "id",
                "orderable": false,
                "className": "text-center"
            },
            {
                "data": "nama_kategori_penerimaan",
                "orderable": false,
            },
            {
                "data": "tahun",
                "orderable": false,
                "className": "text-center"
            },
            {
                "data": "action",
                "orderable": false,
                "className": "text-center"
            },
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

    $('#modalMigrasi').on('shown.bs.modal', function() {
        resetModalMigrasi();
    });

    $(document).on('submit', '#formMigrasi', function(e) {
        e.preventDefault();

        $('#alertMigrasi').html('');

        $.ajax({
            url: $('#formMigrasi').attr('action'),
            type: 'POST',
            data: $('#formMigrasi').serialize(),
            dataType: 'json',
            beforeSend: function() {
                $('#alertMigrasi').html(`
                <div class="alert alert-info">
                    <i class="glyphicon glyphicon-refresh"></i> Memproses migrasi...
                </div>
            `);
            },
            success: function(res) {
                if (res.status == 'success') {
                    $('#alertMigrasi').html(`
                    <div class="alert alert-success">
                        <strong>Sukses!</strong> ${res.message}
                    </div>
                `);

                    $('#formMigrasi')[0].reset();

                    if (t) {
                        t.ajax.reload(null, false);
                    }

                    reloadTahunMigrasi($('#tahun_tujuan').val());

                    setTimeout(function() {
                        $('#modalMigrasi').modal('hide');
                        $('#alertMigrasi').html('');
                    }, 1500);

                } else {
                    $('#alertMigrasi').html(`
                    <div class="alert alert-danger">
                        <strong>Perhatian!</strong> ${res.message}
                    </div>
                `);
                }
            },
            error: function() {
                $('#alertMigrasi').html(`
                <div class="alert alert-danger">
                    <strong>Error!</strong> Terjadi kesalahan saat proses migrasi.
                </div>
            `);
            }
        });
    });
});

function reloadTahunMigrasi(selectedValue = '') {
    $.ajax({
        url: "<?= base_url('MsKategori/Penerimaan/get_tahun_migrasi') ?>",
        type: "GET",
        dataType: "json",
        success: function(res) {
            if (res.status == 'success') {
                let html = '<option value="">Pilih Tahun Referensi</option>';

                $.each(res.data, function(index, item) {
                    let selected = '';

                    if (selectedValue != '' && selectedValue == item.tahun) {
                        selected = 'selected';
                    }

                    html += '<option value="' + item.tahun + '" ' + selected + '>' + item.tahun +
                        '</option>';
                });

                $('#tahun_asal').html(html);
            }
        }
    });
}

function resetModalMigrasi() {
    $('#alertMigrasi').html('');

    if ($('#formMigrasi').length) {
        $('#formMigrasi')[0].reset();
    }

    $('#tahun_asal').val('');
    $('#tahun_tujuan').val('');

    reloadTahunMigrasi('');
}
</script>