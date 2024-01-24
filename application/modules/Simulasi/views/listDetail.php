<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>List</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <div class="pull-right">
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
                                    <th width="5%">No</th>
                                    <!-- <th><center>Cabang</center></th> -->
                                    <th>
                                        <center>id</center>
                                    </th>
                                    <th>
                                        <center>Nama</center>
                                    </th>
                                    <th>
                                        <center>Alamat</center>
                                    </th>
                                    <th>
                                        <center>NIK</center>
                                    </th>
                                    <th>
                                        <center>NIP</center>
                                    </th>
                                    <th>
                                        <center>No. HP</center>
                                    </th>
                                    <th>
                                        <center>Jenis Kelamin</center>
                                    </th>
                                    <th>
                                        <center>Status</center>
                                    </th>
                                    <th>
                                        <center>SKPD</center>
                                    </th>
                                    <th>
                                        <center>Pengingat<br>(Kirim WA)</center>
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
                "url": "<?= base_url() ?>MscbAnggota/getDatatables",
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
                    "data": "id",
                    "orderable": false,
                },
                {
                    "data": "nama",
                    "orderable": false,
                },
                {
                    "data": "alamat",
                    "orderable": false,
                    "className": "text-center"
                },
                {
                    "data": "nik",
                    "orderable": false,
                    "searchable": false,
                    "className": "text-center"
                },
                {
                    "data": "nip",
                    "orderable": false,
                    "className": "text-center"
                },
                {
                    "data": "nomor_hp",
                    "orderable": false,
                    "searchable": false,
                    "className": "text-center"
                },
                {
                    "data": "jenis_kelamin",
                    "orderable": false,
                    "searchable": false,
                    "className": "text-center"
                },
                {
                    "data": "status_keaktifan",
                    "orderable": false,
                    "searchable": false,
                    "className": "text-center"
                },
                {
                    "data": "nama_skpd",
                    "orderable": false,
                    "searchable": false,
                    "className": "text-center"
                },
                {
                    "data": "id",
                    "orderable": false,
                    "searchable": false,
                    "className": "text-center",
                    render: function(data, type, row) {
                        hsl = '<a class="btn btn-xs" style="background-color: orange; color:white" onclick="kirimWA(' + row.id + ')"><i class="glyphicon glyphicon-bullhorn icon-white" title="Kirim Whatsapp"></i></a>';
                        return hsl;
                    },
                },
                {
                    "data": "action",
                    "orderable": false,
                    "className": "text-center",
                    "visible": level == 2 ? false : true,
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
</script>