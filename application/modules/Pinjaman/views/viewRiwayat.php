<div class="page-title">
    <div class="title_left">
        <h3>Riwayat Simpanan</h3>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <ul class="nav navbar-left panel_toolbox">
                    <div class="pull-left">
                      <a onclick="window.history.back()" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-chevron-left"></i> kembali</a>
                    </div>
                  </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="table table-bordered table-striped" id="example2" style="width: 100%">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>SKPD</th>
                        <th>Wajib</th>
                        <th>Sukarela</th>
                        <th>Aksi</th>
                    </tr>
                    <?php $no = 1; ?>
                    <?php foreach ((array)$hasil as $val) { ?>
                        <tr>
                            <td align="center"><?=$no++?></td>
                            <td><?=$this->help->ReverseTgl($val->tgl)?></td>
                            <td><?=$val->nama_skpd?></td>
                            <td><?=number_format($val->wajib)?></td>
                            <td><?=number_format($val->sukarela)?></td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-xs btn-danger" href="<?=base_url()?>Simpanan/delete/<?=$val->id?>"><i class="glyphicon glyphicon-trash icon-white" title="Hapus" onclick="return confirmDelete()"></i></a>';
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $('#example2').dataTable({
        // "searching": false,
        "bSort": false,
        'oLanguage': {
            "sProcessing":   "Sedang memproses...",
            "sLengthMenu":   "Tampilkan _MENU_ entri",
            "sZeroRecords":  "Tidak ditemukan data yang sesuai",
            "sInfo":         "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
            "sInfoEmpty":    "Menampilkan 0 sampai 0 dari 0 entri",
            "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
            "sInfoPostFix":  "",
            "sSearch":       "Cari:",
            "sUrl":          "",
            "oPaginate": {
                "sFirst":    "Pertama",
                "sPrevious": "Sebelumnya",
                "sNext":     "Selanjutnya",
                "sLast":     "Terakhir"
            }
        },
    });
    
});
function confirmDelete() {
    return confirm('Apakah anda yakin?');
};
</script>