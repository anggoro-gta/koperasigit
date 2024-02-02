<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>List</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <div class="pull-right">
                        <a href="<?= base_url() . 'Tagihan/create_individu' ?>" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-plus"></i> Tambah Individu</a>
                        <a href="<?= base_url() . 'Tagihan/create_kolektif' ?>" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-plus"></i> Tambah Kolektif</a>
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
                                    <!-- <th><center>Cabang</center></th> -->
                                    <th>
                                        <center>SKPD</center>
                                    </th>
                                    <th>
                                        <center>Bulan Tahun</center>
                                    </th>
                                    <th>
                                        <center>Kategori</center>
                                    </th>
                                    <th>
                                        <center>Status Posting</center>
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
<script type="text/javascript">
    level = "<?= $this->session->fk_level_id ?>";
    $("#fk_id_skpd").select2();
    $(document).ready(function() {
        var t = $("#example2").dataTable({
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
            ajax: {
                "url": "<?= base_url() ?>Tagihan/getDatatables",
                "type": "POST",
                "data": {
                    "skpd": "<?= $skpd ?>",
                }
            },
            columns: [{
                    "data": "id",
                    "orderable": false,
                    "className": "text-center"
                },
                {
                    "data": "nama_skpd",
                    "orderable": false,
                },
                {
                    "data": "periode",
                    "orderable": false,
                },
                {
                    "data": "kategori",
                    "orderable": false,
                    "className": "text-center"
                },
                {
                    "data": "status_posting",
                    "orderable": false,
                    "className": "text-center",
                    render: function(data, type, row) {
                        status = row.status_posting == 1 ? 'Sudah Posting' : 'Belum Posting';
                        return status
                    }
                },
                {
                    "data": "id",
                    render: function(data, type, row) {
                        btnDelete = ''
                        <?php if (in_array($this->session->userdata('fk_cb_level_id'), [1, 2])) : ?>
                            btnDelete = `
                        <a class="btn btn-xs btn-danger" onclick="return confirm('Apakah Anda akan menghapus data?');"  href="<?= base_url() ?>/Tagihan/delete_${row.kategori}/${row.id}"><i class="fa fa-trash" title="delete"></i>`
                            if (row.status_posting == '1') {
                                btnDelete = '';
                            }
                        <?php endif; ?>
                        aksi = `<div class="btn-group text-center"><a class="btn btn-xs btn-success" href="<?= base_url() ?>/Tagihan/detail_${row.kategori}/${row.id}"><i class="fa fa-eye" title="Detail"></i></a>${btnDelete}</a></div>`
                        return aksi;
                    },
                    "orderable": false,
                    "searchable": false,
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
    });

    function kirimWA(id) {
        $.ajax({
            type: 'POST',
            url: "<?php echo  base_url() . 'MsPelanggan/prosesKirimWA' ?>",
            data: {
                id
            },
            dataType: 'json',
            beforeSend: function() {
                // $('html, body').css("cursor", "auto");
            },
            success: function(msg) {
                alert(msg.notif);
            }
        })
    }

    $("#upload_file").click(function() {
        $("#modal_upload").modal("show");
    });
</script>