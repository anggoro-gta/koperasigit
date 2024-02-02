<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <?php if ($pinjaman) { ?>
            <div class="x_title">
                <h2>Tagihan Pinjaman</h2>
                <ul class="nav navbar-right panel_toolbox">
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <table class="table">
                    <thead>
                        <tr>

                            <th width="5%">No</th>
                            <th>Piut</th>
                            <th>Pinjaman</th>
                            <th>Jns Pinjam</th>
                            <th>Ke</th>
                            <th>Pokok</th>
                            <th>Tapim</th>
                            <th>Bunga</th>
                            <th>X</th>
                            <th>Jumlah</th>
                            <?php if ($readonly) { ?>
                                <th></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <input type="hidden" name="fk_anggota_id" value="<?= $pinjaman->fk_anggota_id ?>">
                            <input type="hidden" name="fk_pinjaman_id" value="<?= $pinjaman->id ?>">
                            <input type="hidden" name="tenor" value="<?= $pinjaman->tenor ?>">
                            <input type="hidden" name="pokok" id="pokok" value="<?= number_format($pinjaman->pokok)  ?>">
                            <input type="hidden" name="tapim" id="tapim" value="<?= number_format($pinjaman->tapim)  ?>">
                            <input type="hidden" name="bunga" id="bunga" value="<?= number_format($pinjaman->bunga)  ?>">
                            <input type="hidden" name="jml_tagihan" id="jml_tagihan" value="<?= number_format($pinjaman->jml_tagihan)  ?>">
                            <input type="hidden" id="min_angsuran" value="<?= $pinjaman->angsuran_ke ?>">
                            <input type="hidden" id="max_angsuran" value="<?= $pinjaman->tenor ?>">
                            <input type="hidden" id="const_pokok" value="<?= number_format($pinjaman->pokok, 0, ",", "")  ?>">
                            <input type="hidden" id="const_tapim" value="<?= number_format($pinjaman->tapim, 0, ",", "")  ?>">
                            <input type="hidden" id="const_bunga" value="<?= number_format($pinjaman->bunga, 0, ",", "")  ?>">
                            <input type="hidden" id="const_jml_tagihan" value="<?= number_format($pinjaman->jml_tagihan, 0, ",", "")  ?>">
                            <td scope="row">1</td>
                            <td><?= $pinjaman->tgl ?></td>
                            <td><?= number_format($pinjaman->pinjaman) ?></td>
                            <td><?= $pinjaman->kategori ?></td>
                            <?php if ($readonly) { ?>
                                <td><?= $pinjaman->angsuran_ke ?></td>
                            <?php } else { ?>
                                <td><input type="text" name="angsuran_ke" class="form-control" id="angsuran_ke" value="<?= $pinjaman->angsuran_ke ?>"></td>

                            <?php } ?>
                            <td id="label_pokok"><?= number_format($pinjaman->pokok) ?></td>
                            <td id="label_tapim"><?= number_format($pinjaman->tapim) ?></td>
                            <td id="label_bunga"><?= number_format($pinjaman->bunga) ?></td>
                            <td><?= $pinjaman->tenor ?></td>
                            <td id="label_jml_tagihan"><?= number_format($pinjaman->jml_tagihan) ?></td>
                            <?php if ($readonly && $pinjaman->angsuran_ke == $pinjaman->jml_angsuran) { ?>
                                <td>
                                    <div class="btn-group text-center"><a class="btn btn-xs btn-danger" onclick="return confirm('Apakah Anda akan menghapus data?');" href="<?php echo base_url() ?>/Tagihan/delete_pinjaman/<?= $pinjaman->id ?>/<?= $pinjaman->fk_tagihan_id ?>"><i class="fa fa-trash"></i></a></div>
                                </td>
                            <?php } ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php } else { ?>
            <div class="x_title">
                <h2 class="text-danger">Tidak Ada Tagihan Pinjaman</h2>
            </div>
        <?php } ?>
    </div>
</div>
<?php if ($simpanan) { ?>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Tagihan Simpanan</h2>
                <ul class="nav navbar-right panel_toolbox">
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="table">
                    <thead>
                        <tr>

                            <th width="5%">No</th>
                            <th>SW</th>
                            <th>Sukarela <?=$readonly==true?></th>
                            <?php if ($readonly) { ?>
                                <th></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>

                        <?php $simpananWajib = $sw > 0 ? $sw : $simpanan->wajib ?>
                        <tr>
                            <input type="hidden" name="wajib" value="<?= number_format($simpananWajib) ?>">
                            <td scope="row">1</td>
                            <td><?= number_format($simpananWajib) ?></td>
                            <td>
                                <?php if ($readonly == false) { ?>
                                    <input type="text" name="sukarela" class="form-control col-md-7 col-xs-12" value="">
                                <?php } else { ?>
                                    <?= number_format($simpanan->sukarela) ?>
                                <?php  } ?>
                            </td>
                            <?php if ($readonly) { ?>
                                <td>
                                    <div class="btn-group text-center"><a class="btn btn-xs btn-danger" onclick="return confirm('Apakah Anda akan menghapus data?');" href="<?php echo base_url() ?>/Tagihan/delete_simpanan/<?= $simpanan->id ?>/<?= $simpanan->fk_tagihan_id ?>"><i class="fa fa-trash"></i></a></div>
                                </td>
                            <?php } ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php } ?>