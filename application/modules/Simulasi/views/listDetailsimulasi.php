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
                                        <center>Jangka waktu</center>
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
                                        <center>Total Angsuran</center>
                                    </th>
                                    <th>
                                        <center>Keterangan</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $iterasi = count($perhitungan_simulasi); ?>
                                <?php for ($i = 0; $i < $iterasi; $i++) { ?>
                                    <tr>
                                        <td align="right"><?= $perhitungan_simulasi[$i]['angsuranke']; ?></td>
                                        <td align="right"><?= number_format($perhitungan_simulasi[$i]['pokok']); ?></td>
                                        <td align="right"><?= number_format($perhitungan_simulasi[$i]['tapim']); ?></td>
                                        <td align="right"><?= number_format($perhitungan_simulasi[$i]['bunga']); ?></td>
                                        <td align="right"><?= number_format($perhitungan_simulasi[$i]['total_angsuran']); ?></td>
                                        <?php if ($perhitungan_simulasi[$i]['angsuranke'] > $sisamasajabatan && $perhitungan_simulasi[$i]['total_angsuran'] > $sisagajipokok) { ?>
                                            <td bgcolor="red">
                                                <font color="white">Simulasi tidak dapat digunakan, karena melebihi sisa gaji pokok dan sisa masa jabatan (bulan).</font>
                                            </td>
                                        <?php } else if ($perhitungan_simulasi[$i]['angsuranke'] > $sisamasajabatan) { ?>
                                            <td bgcolor="red">
                                                <font color="white">Simulasi tidak dapat digunakan, karena melebihi sisa masa jabatan (bulan).</font>
                                            </td>
                                        <?php } else if ($perhitungan_simulasi[$i]['total_angsuran'] > $sisagajipokok) { ?>
                                            <td bgcolor="red">
                                                <font color="white">Simulasi tidak dapat digunakan, karena melebihi sisa gaji pokok.</font>
                                            </td>
                                        <?php } else { ?>
                                            <td bgcolor="green">
                                                <font color="white">Simulasi dapat digunakan.</font>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <!-- <table class="table table-bordered table-striped" id="example3" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>
                                        <center>Saran</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td bgcolor="red">
                                        <font color="white">Simulasi ini tidak aman digunakan, mohon ganti indikator jumlah angsuran atau jumlah pinjaman nya.</font>
                                    </td>
                                </tr>
                            </tbody>
                        </table> -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>