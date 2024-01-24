
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
                                    <th><center>Cabang</center></th>
                                    <th><center>Kode</center></th>
                                    <th><center>Tanggal</center></th>
                                    <th><center>Nama Pelanggan</center></th>
                                    <th><center>No HP<br>Pelanggan</center></th>
                                    <th><center>Alamat</center></th>
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
    
    level = "<?=$this->session->fk_level_id?>";
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
                "url": "<?= base_url() ?>Pos/getDatatables",
                "type": "POST", "data": {"fk_cabang_id": "<?=$fk_cabang_id?>", "fk_pelanggan_id": "<?=$fk_pelanggan_id?>"}
            },
            columns: [{
                    "data": "id",
                    "orderable": false,
                    "className": "text-center"
                },
                {
                    "data": "nama_cabang",
                    "orderable": false,
                },
                {
                    "data": "kode",
                    "orderable": false,
                },
                {
                    "data": "tgl",
                    "orderable": false,
                    "searchable": false,
                    "className": "text-center",
                    "render": function(data, type, row, meta) {
                        return moment(row.tgl).format("DD-MM-YYYY");
                    }
                },
                {
                    "data": "nama_pelanggan",
                    "orderable": false,
                    "className": "text-center"
                },
                {
                    "data": "no_tlp_pelanggan",
                    "orderable": false,
                    "className": "text-center"
                },
                {
                    "data": "alamat_pelanggan",
                    "orderable": false,
                },
                // {
                //     "data": "total",
                //     "orderable": false,
                //     "className": "text-center",
                //     "render": function(data, type, row, meta) {
                //         return `${numberWithCommas(row.total)} K`;
                //     }
                // },
                {
                    "data": "id",
                    "orderable": false,
                    "className": "text-center",
                    render: function(data, type, row) {
                        aksi = '<div class="btn-group">';
                        aksi += '<a class="btn btn-xs btn-success" href="<?= base_url() ?>Pos/show/' + data + '"><i class="fa fa-eye icon-white" title="View"></i></a>';
                        aksi += '<a class="btn btn-xs btn-primary" href="<?= base_url() ?>Pos/print_nota/' + data + '" target="_blank"><i class="fa fa-print icon-white" title="Print"></i></a>';
                        if(level==1){
                            aksi += '<a class="btn btn-xs btn-danger" href="<?=base_url()?>Pos/delete/'+data+'"><i class="glyphicon glyphicon-trash icon-white" title="Hapus" onclick="return confirmDelete()"></i></a>';
                        }
                        aksi += '<a class="btn btn-xs btn-warning" onclick="kirimWA('+data+')"><i class="fa fa-send" title="Kirim Ulang Whatsapp"></i></a>';
                        aksi += '</div>';
                        return aksi;
                    },
                },
            ],
            order: [
                [0, 'desc']
            ],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
                if (data.alasan_void == null) {
                } else {
                    $('td', row).closest('tr').css('background-color', '#f2dede');
                }
            }
        });
    });

function confirmDelete() {
    return confirm('Apakah anda yakin?');
};

function kirimWA(id){
    $.ajax({
        type: 'POST',
        url: "<?php echo  base_url().'Pos/prosesKirimUlangWA'?>",
        data: {id},
        dataType:'json',
        beforeSend  : function(){       
            // $('html, body').css("cursor", "auto");        
        },  
        success: function(msg) {
            alert(msg.notif);
        }
    })
}
</script>