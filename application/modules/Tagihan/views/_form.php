<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
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
                        <?php if ($readonly == false) { ?>
                            <th width="5%" class="text-center">

                                <input type="checkbox" id="checkAllPinjaman" class="flat" />
                            </th>
                        <?php } ?>

                        <th width="5%">NO</th>
                        <th>PIUT</th>
                        <th>NAMA</th>
                        <th>NIP</th>
                        <th>PINJAMAN</th>
                        <th>JNS PINJAM</th>
                        <th>KE</th>
                        <th>POKOK</th>
                        <th>TAPIM</th>
                        <th>BUNGA</th>
                        <th>X</th>
                        <th>JUMLAH</th>
                        <?php if ($readonly) { ?>
                            <th></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pinjaman as $key => $p) { ?>
                        <tr>
                            <?php if ($readonly == false) { ?>
                                <td class="text-center">
                                    <input type="checkbox" class="pinjaman" name="pinjaman[]" class="flat" />
                                    <input type="hidden" name="fk_anggota_id[]" value="<?= $p->fk_anggota_id ?>">
                                    <input type="hidden" name="fk_pinjaman_id[]" value="<?= $p->id ?>">
                                    <input type="hidden" name="angsuran_ke[]" value="<?= $p->angsuran_ke ?>">
                                    <input type="hidden" name="tenor[]" value="<?= $p->tenor ?>">
                                    <input type="hidden" name="pokok[]" value="<?= number_format($p->pokok)  ?>">
                                    <input type="hidden" name="tapim[]" value="<?= number_format($p->tapim)  ?>">
                                    <input type="hidden" name="bunga[]" value="<?= number_format($p->bunga)  ?>">
                                    <input type="hidden" name="jml_tagihan[]" value="<?= number_format($p->jml_tagihan)  ?>">
                                </td>
                            <?php } ?>
                            <td scope="row"><?= ++$key ?></td>
                            <td><?= $p->tgl ?></td>
                            <td><?= $p->nama ?></td>
                            <td><?= $p->nip ?></td>
                            <td><?= number_format($p->pinjaman) ?></td>
                            <td><?= $p->kategori ?></td>
                            <td><?= (int)$p->angsuran_ke ?></td>
                            <td><?= number_format($p->pokok) ?></td>
                            <td><?= number_format($p->tapim) ?></td>
                            <td><?= number_format($p->bunga) ?></td>
                            <td><?= $p->tenor ?></td>
                            <td><?= number_format($p->jml_tagihan) ?></td>
                            <?php if ($readonly && $p->angsuran_ke == $p->jml_angsuran && $status_posting == 0 && in_array($this->session->userdata('fk_cb_level_id'), [1, 2])) { ?>
                                <td>
                                    <div class="btn-group text-center"><a class="btn btn-xs btn-danger" onclick="return confirm('Apakah Anda akan menghapus data?');" href="<?php echo base_url() ?>/Tagihan/delete_pinjaman/<?= $p->id ?>/<?= $p->fk_tagihan_id ?>"><i class="fa fa-trash"></i></a></div>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
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
                        <?php if ($readonly == false) { ?>
                            <th width="5%" class="text-center">
                                <input type="checkbox" id="checkAllSimpanan" class="flat" />
                            </th>
                        <?php } ?>

                        <th width="5%">NO</th>
                        <th>NAMA</th>
                        <th>NIP</th>
                        <th>SW</th>
                        <th>SUKARELA</th>
                        <?php if ($readonly) { ?>
                            <th>TAPIM</th>
                            <th></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($simpanan as $key => $value) { ?>
                        <?php $simpananWajib = $sw > 0 ? $sw : $value->wajib ?>
                        <tr>
                            <?php if ($readonly == false) { ?>
                                <td class="text-center">
                                    <input type="checkbox" class="simpanan" name="simpanan[]" class="flat" />
                                    <input type="hidden" name="wajib[]" value="<?= number_format($simpananWajib) ?>">
                                    <input type="hidden" name="fk_anggota_id[]" value="<?= $value->id ?>">
                                </td>
                            <?php } ?>
                            <td scope="row"><?= ++$key ?></td>
                            <td><?= $value->nama ?></td>
                            <td><?= $value->nip ?></td>
                            <td><?= number_format($simpananWajib) ?></td>
                            <td>
                                <?php if ($readonly == false) { ?>
                                    <input type="text" name="sukarela[]" class="form-control col-md-7 col-xs-12 nominal" value="">
                                <?php } else { ?>
                                    <?= number_format($value->sukarela) ?>
                                <?php  } ?>
                            </td>
                            <?php if ($readonly) : ?>
                                <td><?= number_format($value->tapim) ?></td>
                            <?php endif; ?>

                            <?php if ($readonly && $status_posting == 0 && in_array($this->session->userdata('fk_cb_level_id'), [1, 2])) { ?>
                                <td>
                                    <div class="btn-group text-center"><a class="btn btn-xs btn-danger" onclick="return confirm('Apakah Anda akan menghapus data?');" href="<?php echo base_url() ?>/Tagihan/delete_simpanan/<?= $value->id ?>/<?= $value->fk_tagihan_id ?>"><i class="fa fa-trash"></i></a></div>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php if ($readonly == false) { ?>
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" class="btn btn-primary">Buat Tagihan</button>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<script>
    $('#checkAllSimpanan').click(function() {
        $('.simpanan').prop('checked', this.checked);
    });
    $('#checkAllPinjaman').click(function() {
        $('.pinjaman').prop('checked', this.checked);
    });
</script>
<script>
    $(".nominal").autoNumeric("init", {
        vMax: 9999999999999,
        vMin: -9999999999999
    });
</script>