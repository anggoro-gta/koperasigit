<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>
                    Info Pinjaman - <?= $angg['nama'] . ' (' . $angg['nip'] . ')' ?><br>
                </h2>
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
                                    <th width="35%">
                                        <center>Pinjaman</center>
                                    </th>
                                    <th width="30%">
                                        <center>Tenor</center>
                                    </th>
                                    <th width="30%">
                                        <center>Status</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i = 0; $i < $lengtharraypinjaman; $i++) { ?>
                                    <tr>
                                        <td align="center"><?= $i + 1 ?></td>
                                        <td align="right"><?= number_format($pinjaman[$i]->pinjaman); ?></td>
                                        <td align="center"><?= $pinjaman[$i]->tenor; ?></td>
                                        <?php if ($pinjaman[$i]->status == 0) { ?>
                                            <td align="center"><span class="label label-danger">Belum Lunas</span></td>
                                        <?php } else { ?>
                                            <td align="center"><span class="label label-success">Lunas</span></td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </form>
            </div>

            <?php for ($i = 0; $i < $lengtharraypinjaman; $i++) { ?>
                <div class="x_title">
                    <?php if ($pinjaman[$i]->status == 0) { ?>
                        <h2>
                            Info Detail Pinjaman <?= number_format($pinjaman[$i]->pinjaman); ?> (Tenor <?= $pinjaman[$i]->tenor ?>) <span class="label label-danger">Belum Lunas</span><br>
                        </h2>
                    <?php } else { ?>
                        <h2>
                            Info Detail Pinjaman <?= number_format($pinjaman[$i]->pinjaman); ?> (Tenor <?= $pinjaman[$i]->tenor ?>) <span class="label label-success">Lunas</span><br>
                        </h2>
                    <?php } ?>
                    <ul class="nav navbar-right panel_toolbox">
                    </ul>
                    <div class="clearfix"></div>
                </div>

                <table class="table table-bordered table-striped" id="example2" style="width: 100%">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="35%">
                                <center>Tgl Transaksi</center>
                            </th>
                            <th width="30%">
                                <center>Angsuran ke</center>
                            </th>
                            <th width="30%">
                                <center>Total Tagihan</center>
                            </th>
                        </tr>
                    </thead>
                    <?php $k = 0; ?>
                    <?php for ($j = 0; $j < $lengtharraydetailpinjaman; $j++) { ?>
                        <?php if ($detailpinjaman[$j]->fk_pinjaman_id == $pinjaman[$i]->id) { ?>
                            <tbody>
                                <tr>
                                    <td align="center"><?= $k + 1 ?></td>
                                    <td align="center"><?= $detailpinjaman[$j]->bulan . ' ' . $detailpinjaman[$j]->tahun ?></td>
                                    <td align="center"><?= $detailpinjaman[$j]->angsuran_ke ?></td>
                                    <td align="right"><?= number_format($detailpinjaman[$j]->jml_tagihan) ?></td>
                                </tr>
                                <?php $k = $k + 1; ?>
                            </tbody>
                        <?php } ?>
                    <?php } ?>
                </table>
            <?php } ?>
        </div>
    </div>
</div>