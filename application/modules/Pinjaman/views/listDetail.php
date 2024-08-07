<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>List</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <div class="pull-right">
                        <!-- <a href="#" id="upload_file" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-cloud-upload"></i> Upload</a> -->
                        <a href="<?= $act_add ?>" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-plus"></i> Tambah</a>
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
                                    <th width="5%">NO</th>
                                    <!-- <th><center>Cabang</center></th> -->
                                    <th>
                                        <center>NAMA ANGGOTA</center>
                                    </th>
                                    <th>
                                        <center>TANGGAL PINJAM</center>
                                    </th>
                                    <th>
                                        <center>JUMLAH PINJAMAN</center>
                                    </th>
                                    <th>
                                        <center>ANGSURAN YG TERBAYAR</center>
                                    </th>
                                    <th>
                                        <center>TENOR</center>
                                    </th>
                                    <th>
                                        <center>POKOK</center>
                                    </th>
                                    <th>
                                        <center>TAPIM</center>
                                    </th>
                                    <th>
                                        <center>BUNGA</center>
                                    </th>
                                    <th>
                                        <center>TAGIHAN BULANAN</center>
                                    </th>
                                    <th>
                                        <center>JENIS</center>
                                    </th>
                                    <th>
                                        <center>STATUS LUNAS</center>
                                    </th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade slide-up disable-scroll" id="modal_upload" role="dialog" aria-hidden="false">
    <div class="modal-dialog" style="width: 50%;padding: 0px">
        <div class="modal-content">
            <form method="post" action="<?= base_url("Simpanan/saveUpload") ?>" enctype="multipart/form-data" class="form-horizontal">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                    <h5><b>UPLOAD SIMPANAN</b></h5>
                </div>
                <div class="modal-body">
                    <div class="form-group required">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12">SKPD</label>
                        <div class="col-md-8 col-sm-10 col-xs-12">
                            <div class="input-group">
                                <select class="form-control" name="fk_id_skpd" id="fk_id_skpd" required>
                                    <option value="">.: Pilih :.</option>
                                    <?php foreach ($arrSkpd as $val) { ?>
                                        <option value="<?= $val['id'] ?>"><?= $val['nama_skpd'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-md-3 col-sm-6 col-xs-12 control-label">Tanggal</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control tanggal text-center" name="tgl" required>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-md-3 col-sm-6 col-xs-12 control-label">Upload File</label>
                        <div class="col-md-9">
                            <input type="file" class="form-control" name="fileExcel" accept=".xsl, .xlsx" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-md btn-default pull-left inline" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-md btn-success pull-left inline">Proses Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    level = "<?= $this->session->fk_level_id ?>";

    statuslunas = "lunas";
    statusblmlunas = "belum lunas"

    $("#fk_id_skpd").select2();
    $('.tanggal').datepicker({
        autoclose: true,
    });
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
            "pageLength": 100,
            ajax: {
                "url": "<?= base_url() ?>Pinjaman/getDatatables",
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
                    "data": "nama",
                    "orderable": false,
                },
                {
                    "data": "tgl",
                    "orderable": false,
                    "className": "text-center",
                    "searchable": false,
                },
                {
                    "data": "pinjaman",
                    "orderable": false,
                    "className": "text-right",
                    "searchable": false,
                },
                {
                    "data": "jml_angsuran",
                    "orderable": false,
                    "className": "text-center",
                    "searchable": false,
                },
                {
                    "data": "tenor",
                    "orderable": false,
                    "className": "text-center",
                    "searchable": false,
                },
                {
                    "data": "pokok",
                    "orderable": false,
                    "className": "text-right",
                    "searchable": false,
                },
                {
                    "data": "tapim",
                    "orderable": false,
                    "className": "text-right",
                    "searchable": false,
                },
                {
                    "data": "bunga",
                    "orderable": false,
                    "className": "text-right",
                    "searchable": false,
                },
                {
                    "data": "jml_tagihan",
                    "orderable": false,
                    "className": "text-right",
                    "searchable": false,
                },
                {
                    "data": "kategori",
                    "orderable": false,
                    "className": "text-center",
                    "searchable": false,
                },
                {
                    "data": "status",
                    "orderable": false,
                    "className": "text-center",
                },
                {
                    "data": "id",
                    "orderable": false,
                    "className": "text-center",
                    render: function(data, type, row) {
                        aksi = '<div class="btn-group">';
                        if (row.jml_angsuran == 0) {
                            aksi += '<a class="btn btn-xs btn-danger" href="<?= base_url() ?>Pinjaman/delete/' + data + '"><i class="glyphicon glyphicon-trash icon-white" title="Hapus" onclick="return confirmDelete()"></i></a>';
                        }
                        aksi += '</div>';
                        return aksi;
                    },
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

    function confirmDelete() {
        return confirm('Apakah anda yakin?');
    };

    $("#upload_file").click(function() {
        $("#modal_upload").modal("show");
    });
</script>