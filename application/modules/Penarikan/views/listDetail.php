<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>List</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <div class="pull-right">
                        <!-- <a href="#" id="upload_file" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-cloud-upload"></i> Upload</a> -->
                        <a href="<?= $act_add ?>" class="btn btn-sm btn-success"><i
                                class="glyphicon glyphicon-plus"></i> Tambah</a>
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
                                        <center>TANGGAL PENARIKAN</center>
                                    </th>
                                    <th>
                                        <center>JUMLAH PENARIKAN</center>
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
            "url": "<?= base_url() ?>Penarikan/getDatatables",
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
                "data": "jumlah",
                "orderable": false,
                "className": "text-right",
                "searchable": false,
            },
            {
                "data": "id",
                "orderable": false,
                "className": "text-center",
                render: function(data, type, row) {
                    aksi = '<div class="btn-group">';
                    aksi +=
                        '<a class="btn btn-xs btn-primary" href="<?= base_url() ?>Penarikan/edit/' +
                        data +
                        '"><i class="glyphicon glyphicon-edit icon-white" title="Edit"></i></a>';
                    aksi +=
                        '<button type="button" class="btn btn-xs btn-danger btn-del" data-id="' +
                        data + '">' +
                        '<i class="glyphicon glyphicon-trash"></i></button>';
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

function confirmDelete() {
    return confirm('Yakin ingin menghapus data ini?');
}

$(document).on('click', '.btn-del', function() {
    var id = $(this).data('id');
    if (!id) return;

    if (!confirmDelete()) return;

    $.ajax({
        url: "<?= site_url('Penarikan/ajax_delete') ?>/" + id,
        type: "POST",
        dataType: "json",
        success: function(res) {
            if (!res.ok) {
                alert(res.message || 'Gagal menghapus');
                return;
            }
            alert(res.message || 'Berhasil dihapus');

            // refresh datatable tanpa reload halaman
            $('#example2').DataTable().ajax.reload(null, false);
        },
        error: function() {
            alert('Error saat hapus. Cek console/network.');
        }
    });
});
</script>