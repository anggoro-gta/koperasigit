<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Hasil Simulasi</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <div class="pull-right">
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
                                    <th width="5%">
                                        <center>Angsuran Ke</center>
                                    </th>
                                    <th>
                                        <center>Pokok</center>
                                    </th>
                                    <th>
                                        <center>Tapim</center>
                                    </th>
                                    <th>
                                        <center>Bunga</center>
                                    </th>
                                    <th>
                                        <center>Total Tagihan</center>
                                    </th>
                                    <th>
                                        <center>Keterangan</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i = 0; $i < $jumlahangsuran; $i++) { ?>
                                    <tr>
                                        <td align="right"><?= $i + 1; ?></td>
                                        <td align="right"><?= number_format($pokok); ?></td>
                                        <td align="right"><?= number_format($tapim); ?></td>
                                        <td align="right"><?= number_format($bunga); ?></td>
                                        <?php $jumlah = $jumlahtagihan * ($i + 1); ?>
                                        <td align="right"><?= number_format($jumlah); ?></td>
                                        <?php $angsuranke = ($i + 1); ?>
                                        <?php if ($angsuranke > $sisamasajabatan && $jumlah > $sisagajipokok) { ?>
                                            <td bgcolor="red">
                                                <font color="white">Tidak Aman - Melebihi sisa gaji pokok dan sisa masa jabatan</font>
                                            </td>
                                        <?php } else if ($jumlah > $sisagajipokok) { ?>
                                            <td bgcolor="red">
                                                <font color="white">Tidak Aman - Melebihi sisa gaji pokok</font>
                                            </td>
                                        <?php } else if ($angsuranke > $sisamasajabatan) { ?>
                                            <td bgcolor="red">
                                                <font color="white">Tidak Aman - Melebihi sisa masa jabatan</font>
                                            </td>
                                        <?php } else { ?>
                                            <td bgcolor="green" textcolor="white">
                                                <font color="white">Aman</font>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <table class="table table-bordered table-striped" id="example3" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>
                                        <center>Saran</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php if (($jumlahtagihan * $jumlahangsuran) > $sisagajipokok || $jumlahangsuran > $sisamasajabatan) { ?>
                                        <td bgcolor="red">
                                            <font color="white">Simulasi ini tidak aman digunakan, mohon ganti indikator jumlah angsuran atau jumlah pinjaman nya.</font>
                                        </td>
                                    <?php } else { ?>
                                        <td bgcolor="green">
                                            <font color="white">Simulasi ini aman digunakan, silahkan menghubungi petugas koperasi untuk menggunakan simulasi ini.</font>
                                        </td>
                                    <?php } ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>