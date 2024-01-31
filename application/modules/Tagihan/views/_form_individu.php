<?php if ($pinjaman) { ?>

    <div class="col-md-6 col-sm-6 col-xs-6">
        <div class="x_panel">
            <div class="x_title">
                <h2>Tagihan Pinjaman</h2>
                <ul class="nav navbar-right panel_toolbox">
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <input type="hidden" name="fk_pinjaman_id" value="<?= $pinjaman->id ?>">
                <input type="hidden" id="min_angsuran" value="<?= $pinjaman->angsuran_ke ?>">
                <input type="hidden" id="max_angsuran" value="<?= $pinjaman->tenor ?>">
                <input type="hidden" id="const_pokok" value="<?= number_format($pinjaman->pokok, 0, ",", "")  ?>">
                <input type="hidden" id="const_tapim" value="<?= number_format($pinjaman->tapim, 0, ",", "")  ?>">
                <input type="hidden" id="const_bunga" value="<?= number_format($pinjaman->bunga, 0, ",", "")  ?>">
                <input type="hidden" id="const_jml_tagihan" value="<?= number_format($pinjaman->jml_tagihan, 0, ",", "")  ?>">
                <div class="form-group required">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Piut</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" readonly class="form-control col-md-7 col-xs-12" value="<?= $pinjaman->tgl ?>">
                    </div>
                </div>
                <div class="form-group required">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Pinjaman</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" readonly class="form-control col-md-7 col-xs-12" value="<?= number_format($pinjaman->pinjaman, 0, ",", ".") ?>">
                    </div>
                </div>
                <div class="form-group required">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Jns Pinjam</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="kategori" readonly class="form-control col-md-7 col-xs-12" value="<?= $pinjaman->kategori ?>">
                    </div>
                </div>
                <div class="form-group required">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Ke</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="number" name="angsuran_ke" id="angsuran_ke" class="form-control col-md-7 col-xs-12" value="<?= $pinjaman->angsuran_ke ?>">
                    </div>
                </div>
                <div class="form-group required">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Pokok</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="pokok" id="pokok" readonly class="form-control col-md-7 col-xs-12" value="<?= number_format($pinjaman->pokok, 0, ",", ".") ?>">
                    </div>
                </div>
                <div class="form-group required">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Tapim</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="tapim" id="tapim" readonly class="form-control col-md-7 col-xs-12" value="<?= number_format($pinjaman->tapim, 0, ",", ".") ?>">
                    </div>
                </div>
                <div class="form-group required">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Bunga</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="bunga" id="bunga" readonly class="form-control col-md-7 col-xs-12" value="<?= number_format($pinjaman->bunga, 0, ",", ".") ?>">
                    </div>
                </div>
                <div class="form-group required">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">X</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="tenor" readonly class="form-control col-md-7 col-xs-12" value="<?= number_format($pinjaman->tenor, 0, ",", ".") ?>">
                    </div>
                </div>
                <div class="form-group required">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Jumlah</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="jml_tagihan" id="jml_tagihan" readonly class="form-control col-md-7 col-xs-12" value="<?= number_format($pinjaman->jml_tagihan, 0, ",", ".") ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<div class="col-md-6 col-sm-6 col-xs-6">
    <div class="x_panel">
        <div class="x_title">
            <h2>Tagihan Simpanan</h2>
            <ul class="nav navbar-right panel_toolbox">
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <input type="hidden" id="sw" value="<?= number_format($sw, 0, ",", "")  ?>">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Jml</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="number" name="jml" id="jml" class="form-control col-md-7 col-xs-12" value="">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">SW</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="wajib" id="wajib" readonly class="form-control col-md-7 col-xs-12" value="">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Sukarela</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="number" name="sukarela" class="form-control col-md-7 col-xs-12" value="">
                </div>
            </div>
        </div>
    </div>
</div>