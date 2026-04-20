<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Info Simpanan - <?= $angg['nama'] . ' (' . $angg['nip'] . ')' ?></h2>
                <ul class="nav navbar-right panel_toolbox">
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
                                    <!-- <th>
                                        <center>Transaksi Terakhir</center>
                                    </th> -->
                                    <th width="45%">
                                        <center>Uraian</center>
                                    </th>
                                    <th width="50%">
                                        <center>Saldo</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td align="center">1</td>
                                    <!-- <td align="center"><?= $this->help->ReverseTgl($angg['tanggal_mulai_aktif']) ?></td> -->
                                    <td>SIMPANAN POKOK</td>
                                    <td align="right"><?= number_format($angg['simpanan_pokok']) ?></td>
                                </tr>
                                <tr>
                                    <td align="center">2</td>
                                    <!-- <td align="center"><?= $wjb->bulan . '-' . $wjb->tahun ?></td> -->
                                    <td>SIMPANAN WAJIB</td>
                                    <td align="right"><?= number_format($wjb->wajib) ?></td>
                                </tr>
                                <tr>
                                    <td align="center">3</td>
                                    <!-- <td align="center"><?= $tpm->bulan . '-' . $tpm->tahun ?></td> -->
                                    <td>SIMPANAN TERPIMPIN</td>
                                    <td align="right"><?= number_format($tpm->tapim) ?></td>
                                </tr>
                                <tr>
                                    <td align="center">4</td>
                                    <!-- <td align="center"><?= $wjb->bulan . '-' . $wjb->tahun ?></td> -->
                                    <td>SIMPANAN SUKARELA</td>
                                    <td align="right"><?= number_format($wjb->sukarela) ?></td>
                                </tr>
                                <tr>
                                    <td align="center" colspan="2"><b>TOTAL</b></td>
                                    <td align="right"><b><?= number_format($angg['simpanan_pokok'] + $wjb->wajib + $tpm->tapim + $wjb->sukarela) ?></b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>

            <div class="x_title">
                <h2>Detail Simpanan Pokok</h2>
                <ul class="nav navbar-right panel_toolbox">
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br />
                <!-- <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left"> -->
                <div class="form-group">
                    <table class="table table-bordered table-striped" id="example2" style="width: 100%">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="45%">
                                    <center>Tgl Transaksi</center>
                                </th>
                                <th width="50%">
                                    <center>Saldo</center>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td align="center">1</td>
                                <td align="center"><?= $this->help->ReverseTgl($angg['tanggal_mulai_aktif']) ?></td>
                                <td align="right"><?= number_format($angg['simpanan_pokok']) ?></td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2"><b>TOTAL</b></td>
                                <td align="right"><b><?= number_format($angg['simpanan_pokok']) ?></b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- </form> -->
            </div>

            <div class="x_title">
                <h2>Detail Simpanan Wajib</h2>
                <ul class="nav navbar-right panel_toolbox">
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br />
                <!-- <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left"> -->
                <div class="form-group">
                    <table class="table table-bordered table-striped" id="example2" style="width: 100%">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="45%">
                                    <center>Tgl Transaksi</center>
                                </th>
                                <th width="50%">
                                    <center>Saldo</center>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($wjb->wajib  == 0) { ?>
                                <tr>
                                    <td align="center" colspan="3">Tidak ada data simpanan wajib</td>
                                </tr>
                            <?php } else { ?>
                                <?php if ($angg['simpanan_wajib'] == 0) { ?>
                                    <?php for ($i = 0; $i < $lengtharraywajib; $i++) { ?>
                                        <tr>
                                            <td align="center"><?= $i + 1 ?></td>
                                            <td align="center"><?= $wajiball[$i]->bulan . "-" . $wajiball[$i]->tahun; ?></td>
                                            <td align="right"><?= number_format($wajiball[$i]->wajib) ?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td align="center" colspan="2"><b>TOTAL</b></td>
                                        <td align="right"><b><?= number_format($wjb->wajib) ?></b></td>
                                    </tr>
                                <?php } else { ?>
                                    <tr>
                                        <td align="center">1</td>
                                        <td align="center"><?= $this->help->ReverseTgl($angg['tanggal_mulai_aktif']) ?></td>
                                        <td align="right"><?= number_format($angg['simpanan_wajib']) ?></td>
                                    </tr>
                                    <?php $j = 1; ?>
                                    <?php for ($i = 0; $i < $lengtharraywajib; $i++) { ?>
                                        <tr>
                                            <td align="center"><?= $j + 1 ?></td>
                                            <td align="center"><?= $wajiball[$i]->bulan . "-" . $wajiball[$i]->tahun; ?></td>
                                            <td align="right"><?= number_format($wajiball[$i]->wajib) ?></td>
                                            <?php $j = $j + 1; ?>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td align="center" colspan="2"><b>TOTAL</b></td>
                                        <td align="right"><b><?= number_format($wjb->wajib) ?></b></td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- </form> -->
            </div>

            <div class="x_title">
                <h2>Detail Simpanan Terpimpin</h2>
                <ul class="nav navbar-right panel_toolbox">
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br />
                <!-- <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left"> -->
                <div class="form-group">
                    <table class="table table-bordered table-striped" id="example2" style="width: 100%">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="45%">
                                    <center>Tgl Transaksi</center>
                                </th>
                                <th width="50%">
                                    <center>Saldo</center>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($tpm->tapim  == 0) { ?>
                                <tr>
                                    <td align="center" colspan="3">Tidak ada data simpanan terpimpin</td>
                                </tr>
                            <?php } else { ?>
                                <?php for ($i = 0; $i < $lengharraytapim; $i++) { ?>
                                    <tr>
                                        <td align="center"><?= $i + 1 ?></td>
                                        <td align="center"><?= $tapimall[$i]->bulan . "-" . $tapimall[$i]->tahun; ?></td>
                                        <td align="right"><?= number_format($tapimall[$i]->tapim) ?></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td align="center" colspan="2"><b>TOTAL</b></td>
                                    <td align="right"><b><?= number_format($tpm->tapim) ?></b></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- </form> -->
            </div>

            <div class="x_title">
                <h2>Detail Simpanan Sukarela</h2>
                <ul class="nav navbar-right panel_toolbox">
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br />
                <!-- <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left"> -->
                <div class="form-group">
                    <table class="table table-bordered table-striped" id="example2" style="width: 100%">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="45%">
                                    <center>Tgl Transaksi</center>
                                </th>
                                <th width="50%">
                                    <center>Saldo</center>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($wjb->sukarela  == 0) { ?>
                                <tr>
                                    <td align="center" colspan="3">Tidak ada data simpanan sukarela</td>
                                </tr>
                            <?php } else { ?>
                                <?php for ($i = 0; $i < $lengtharraysukarela; $i++) { ?>
                                    <tr>
                                        <td align="center"><?= $i + 1 ?></td>
                                        <td align="center"><?= $sukarelaall[$i]->bulan . "-" . $sukarelaall[$i]->tahun; ?></td>
                                        <td align="right"><?= number_format($sukarelaall[$i]->sukarela) ?></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td align="center" colspan="2"><b>TOTAL</b></td>
                                    <td align="right"><b><?= number_format($wjb->sukarela) ?></b></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- </form> -->
            </div>

        </div>
    </div>
</div>