<div class="page-title">
    <div class="title_left">
        <h3>View Transaksi</h3>
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
                        <td>Cabang</td>
                        <td align="center" width="10px">:</td>
                        <td><?=$cabang->nama_cabang?></td>
                        <td>Tanggal</td>
                        <td align="center" width="10px">:</td>
                        <td><?=$this->help->ReverseTgl($pos->tgl)?></td>
                    </tr>
                    <tr>
                        <td>Kode</td>
                        <td>:</td>
                        <td><?=$pos->kode?></td>
                        <td>Pelanggan</td>
                        <td>:</td>
                        <td><?=$pos->nama_pelanggan?></td>
                    </tr>
                </table>
                <label style="color: blue"><u>Detail Transaksi</u></label>
                <table class="table table-bordered table-striped" id="example2" style="width: 100%">
                    <tr>
                        <th>No</th>
                        <th>Nama Paket</th>
                        <th>Tarif</th>
                        <th>Terapis</th>
                        <th>Fee Terapis</th>
                        <th>Keterangan</th>
                    </tr>
                    <?php $no = 1; ?>
                    <?php foreach ((array)$detail as $val) { ?>
                        <tr>
                            <td align="center"><?=$no++?></td>
                            <td><?=$val->nama_paket?></td>
                            <td><?=number_format($val->nominal_paket)?></td>
                            <td><?=$val->nama_terapis?></td>
                            <td><?=number_format($val->fee_terapis)?></td>
                            <td><?=$val->keterangan?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>